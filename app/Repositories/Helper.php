<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class Helper
{
    public function __construct()
    {
    }

    /**
     * get all array by key and value
     *
     * @param array     $array          source arary.
     * @param any       $filterVal      value to filter.
     * @param string    $key_column     array key name.
     *
     * @return array filtered array.
     */
    public function filterby($array, $filterVal, $key_column)
    {
        return array_filter($array, function ($var) use ($filterVal, $key_column) {
            return ($var[$key_column] == $filterVal);
        });
    }

    /**
     *
     */
    public function get_ucwords($_input, $_flag)
    {
        if ($_flag === true) {
            return ucwords(strtolower($_input));
        }
        return $_input;
    }

    /**
     * Get string only alpha-character
     *
     * @param string $input     message.
     * @return string filtered string
     */
    public function regex_letter($input)
    {
        return preg_replace('/[^a-zA-Z]+/', '', $input);
    }

    /**
     * Convert data in dotSeperate format to Array
     * Example input array = [ 'CORPORATE.MA', 'CORPORATE.USER' ]
     * Convert Result as
     * [
     *    [ 'k1' => 'CORPORATE', 'k2' => [ 'MA', 'USER' ] ]
     * ]
     *
     * @param array $array    source array.
     * @param string $key1    (Optional) array key name k1. Default: 'type'
     * @param string $key2    (Optional) array key name k2. Default: 'data'
     * @param string $strtoucword    (Optional) set it true to convert all string to ucwords. Default: true
     *
     * @return array convert result.
     */
    public function dotSeparaterToArray($array, $key1 = 'type', $key2 = 'data', $strtoucword = true)
    {
        $types = [];
        foreach ($array as $k) {
            $_split = explode('.', $k);
            array_push($types, $_split[0]);
        }
        $types = array_unique($types);

        $result = [];
        foreach ($types as $t) {
            $item = [];
            foreach ($array as $key) {
                if (strpos($key, "{$t}.") !== false) {
                    $_split = explode('.', $key);
                    array_push($item, $this->get_ucwords($_split[1], $strtoucword));
                }
            }
            array_push($result, [
                "{$key1}"      => $this->get_ucwords($t, $strtoucword),
                "{$key2}"      => $item,
            ]);
        }

        return $result;
    }

    /**
     * Change key name equal to key value
     *
     * Example
     * Expected $array Input as
     * [
     *    [ 'k1' => 'CORPORATE', 'k2' => [ 'MA', 'USER' ] ]
     * ]
     *
     * @return array convert result.
     */
    public function set_Kname_as_Kvalue($array, $k1, $k2)
    {
        $result = [];
        foreach ($array as $key) {
            $_arr = [];
            foreach ($key[$k2] as $subkey) {
                $_arr["{$subkey}"] = $subkey;
            }
            $result["{$key[$k1]}"] = $_arr;
        }

        return $result;
    }

    /**
     *  Searching data in
     *
     *      filtered = array[`$search_col`] == $search_val
     *
     *  Then sum value from filtered array
     *
     *      sum(filtered[`$sum_col`])
     */
    public function search_and_sum($arr, $sum_col, $search_col, $search_val)
    {
        $filtered = array_filter($arr, function ($item) use ($search_col, $search_val) {
            return $item[$search_col] == $search_val;
        });
        return array_sum(array_column($filtered, $sum_col));
    }
    
    public function IsNullOrEmpty($string)
    {
        return !isset($string) && $string == '';
    }

    public function generateSalt($_lenght = 16)
    {
        return str_replace(['+', '/', '='], '', base64_encode(openssl_random_pseudo_bytes($_lenght)));
    }

    public function validateUser($user)
    {
        if (!$user) {
            return [
                'message'   =>  'Username does not exist.',
                'code'      =>  'auth/user-not-exist'
            ];
        } elseif ($user->is_activated == false) {
            return [
                'message'   =>  'User not activated.',
                'code'      =>  'auth/user-not-activate'
            ];
        } elseif ($user->expired_at < date('Y-m-d H:i:s')) {
            return [
                'message'   =>  'Account has been expired.',
                'code'      =>  'auth/token-expired'
            ];
        } elseif ($user->status != 'ACTIVE') {
            return [
                'message'   =>  'User is inactive.',
                'code'      =>  'auth/user-inactive'
            ];
        } elseif ($user->lock_reason != null) {
            return [
                'message'   =>  'User has been locked.',
                'code'      =>  'auth/user-locked'
            ];
        } elseif ($user->login_attempt > 2) {
            return [
                'message'   =>  'Account locked. Maximum attempts reached.',
                'code'      =>  'auth/user-locked'
            ];
        }  

        return null;
    }

    public function PostRequest($client, $url, $data, $headers = [])
    {
        $token = Session::get('token') ?? '';

        try {
            $data = [ 
                'json' => $data 
            ];
            if ( count($headers) > 0 ) {
                $data['headers'] = $headers;
                if (!isset($data['headers']['Authorization'])) {
                    $data['headers']['Authorization'] = 'Bearer '.$token;
                }
            } else {
                $data['headers'] = [
                    'Authorization'     =>  'Bearer '.$token
                ];
            }

            $response = $client->post($url, $data);
            $result = json_decode($response->getBody()->getContents());

            if ( !$result ) {
                $result = new \stdClass();
                $result->code = '';
                $result->message = '';
                $result->success = false;
            }

            return $result;

        } catch (\Exception $e) {
            report($e);

            return (object)[
                'success'   => false,
                'message'   => ( new \App\Repositories\ExceptionMessage() )->getMessage($e),
                'code'      => $e->getCode()
            ];
        }
    }

    public function GetRequest($client, $url, $headers = [])
    {
        $token = Session::get('token') ?? '';

        try {
            $response = null;
            if (count($headers) > 0) {
                if (!isset($headers['Authorization'])) {
                    $headers['Authorization'] = 'Bearer '.$token;
                }
                $response = $client->get($url, [
                    'headers'       => $headers
                ]);
            } else {
                $response = $client->get($url, [
                    'headers'       => [
                        'Authorization'     =>  'Bearer '.$token
                    ]
                ]);
            }
            $result = json_decode($response->getBody()->getContents());
            if ( !$result ) {
                $result = new \stdClass();
                $result->code = '';
                $result->message = '';
                $result->success = false;
            }

            return $result;

        } catch (\Exception $e) {
            report($e);

            return (object)[
                'success'   => false,
                'message'   => ( new \App\Repositories\ExceptionMessage() )->getMessage($e),
                'code'      => $e->getCode()
            ];
        }
    }

    public function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && ( int ) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }
    
    public function getErrorMsg($code, $optional = '')
    {
        $err = '';
        switch ((string)$code) {
            case '2101':
                $err = 'เกิดข้อผิดพลาด ไม่พบข้อมูลวันหมดอายุ otp ในระบบไม่ถูกต้อง';
                break;
            case '2102':
                $err = 'รหัสหมดอายุ กรุณากดขอ otp ใหม่อีกครั้ง';
                break;
            case '2103':
                $err = 'เกิดข้อผิดพลาด ไม่พบข้อมูลในระบบ';
                break;
            case '2104':
                $err = 'รหัส otp ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง';
                break;
            default:
                break;
        }
        return !blank($err) ? $err : $optional;
    }

    public function is_all_equal(array $array, array $exclude, Callable $func) : bool
    {
        foreach($array as $key => $value) {
            if (in_array($key, $exclude)) {
                continue;
            } else if ($func($value) !== true) {
                return false;
            }
        }
        return true;
    }

    public function ServiceException($exception)
    {
        $response_exception = json_decode($exception->getResponse()->getBody()->getContents());
        if ($response_exception->code === 99) {
            return (new AuthToken())->ExceptionToken($response_exception);
        } else {
            return null;
        }
    }

    public function getMimeType($base64) 
    {
        $decoded = null;
        $exploded = explode(',', $base64);
        if (count($exploded) > 1) {
            $decoded = base64_decode($exploded[1]);
        }
        else {
            $decoded = base64_decode($base64);
        }
        $info = getimagesizefromstring($decoded);
        return $info['mime'];
    }
    
    public function getExtensionFileContent($base64) 
    {
        $mime = $this->getMimeType($base64);
        $file_extension = array_pad(explode('/', $mime), 2, '')[1];
        if (blank($file_extension)) {
            throw new Exception('file extension has a null.');
        }
        return $file_extension;
    }
}
