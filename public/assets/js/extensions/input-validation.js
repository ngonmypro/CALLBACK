const INPUT_REQUIRED = (elem, data) => {
	if (data === '' || data === null) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
    	return false  
    } else {
    	$(elem).removeClass('is-invalid').addClass('is-valid')
        return true
    }
}
const SELECT_REQUIRED = (elem, data) => {
	if ($(elem).val() === '' || $(elem).val() === null || $(elem).val() === '-') {	
        
        $(elem).removeClass('is-valid').addClass('is-invalid')
        return false
    } else {	
    	$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
    }
}
const INPUT_NUMBER = (elem, data) => {
	if (isNaN(data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}
const INPUT_MIN = (elem, data , minlength) => {
	if(minlength !== '') {
		if(data.length < parseInt(minlength)) {
			$(elem).removeClass('is-valid').addClass('is-invalid')
			return false
		}
		else{
			$(elem).removeClass('is-invalid').addClass('is-valid')
			return true
		}
	}
	else{
        $(elem).removeClass('is-valid').addClass('is-invalid')
        return false
	}
}
const INPUT_MAX = (elem, data , maxlength) => {
	if (maxlength !== '') {
		if(parseInt(data.length) !== parseInt(maxlength)) {
			$(elem).removeClass('is-valid').addClass('is-invalid')
			return false
		}
		else {
			$(elem).removeClass('is-invalid').addClass('is-valid')
			return true
		}
	} else {
        return false
	}
}
const INPUT_LENGTH = (elem, data , condition_length) => {
	if (condition_length !== '') {
		if (parseInt(data.length) !== parseInt(condition_length)) {
			$(elem).removeClass('is-valid').addClass('is-invalid')
			return false
		} else {
			$(elem).removeClass('is-invalid').addClass('is-valid')
			return true
		}
	} else{
        return false
	}
}

const NUMERIC_MIN = (elem, data, min) => {
    if (parseInt(data) < parseInt(min)) {
        $(elem).removeClass('is-valid').addClass('is-invalid')
        return false
    } else {
        $(elem).removeClass('is-invalid').addClass('is-valid')
        return true
    }
}

const NUMERIC_MAX = (elem, data, max) => {
    if (parseFloat(data) > parseFloat(max)) {
        $(elem).removeClass('is-valid').addClass('is-invalid')
        return false
    } else {
        $(elem).removeClass('is-invalid').addClass('is-valid')
        return true
    }
}

const INPUT_NULLABLE = (elem, data) => {
	if (data === '' || data === null) {
		$(elem).addClass('is-valid').removeClass('is-invalid')
		return true
	}
}

const INPUT_URL = (elem, data) => {
	if (!validURL(data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}

const INPUT_JSON = (elem, data) => {
	if (!IsValidJSONString(data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}
const INPUT_TH_ONLY_NUMBER_SPACE = (elem, data) => {
	if (!valid_INPUT_TH_ONLY_NUMBER_SPACE(data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}
const INPUT_TH_ONLY = (elem, data) => {
	if (!valid_INPUT_TH_ONLY(data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}

const INPUT_EN_ONLY_NUMBER_SPACE = (elem, data) => {
	if (!valid_INPUT_EN_ONLY_NUMBER_SPACE(data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}
const INPUT_EN_ONLY = (elem, data) => {
	if (!valid_INPUT_EN_ONLY(data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}
const INPUT_MOBILE = (elem, data) => {
	if (!valid_INPUT_MOBILE(elem,data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}
const INPUT_CITIZEN = (elem, data) => {
	if (!valid_INPUT_CITIZEN(elem, data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}
const INPUT_EMAIL = (elem, data) => {
	if (!valid_INPUT_EMAIL(elem, data)) {
		$(elem).removeClass('is-valid').addClass('is-invalid')
		return false
	} else {
		$(elem).removeClass('is-invalid').addClass('is-valid')
		return true
	}
}
const INPUT_RADIO = (elem, data) => {
    const input_name = $(elem).attr('name')
	if ($(`input[name=${input_name}]:checked`).length === 0) {
        $(`input[name=${input_name}]`).each(function() {
            $(this).removeClass('is-valid').addClass('is-invalid')
        })
        return false
    }
    else {
        $(`input[name=${input_name}]`).each(function() {
            $(this).removeClass('is-invalid').addClass('is-valid')
        })
        return true
    }
}

const InputValidation = (rule, callback = null) => {
	let success = true

	rule.forEach((item) => {
        let is_valid = true
        const { data, elem, rule, option } = item
        const { minlength, maxlength, length } = option || {}
        const elem_id = elem

		return rule.forEach((elem) => {

			if (!is_valid) {
				return
			}

			switch (elem) {
				case 'REQUIRED':
					if (!INPUT_REQUIRED(elem_id, data)) {
						is_valid = false
						success = false
					}
					break;
				case 'NUMBER':
					if (!INPUT_NUMBER(elem_id, data)) {
						is_valid = false
						success = false
					}
					break;
				case 'MIN':
					if (!INPUT_MIN(elem_id, data, minlength || '')) {
						is_valid = false
						success = false
					}
					break;
				case 'MAX':
					if (!INPUT_MAX(elem_id, data, maxlength || '')) {
						is_valid = false
						success = false
					}
					break;
				case 'LENGTH':
					if (!INPUT_LENGTH(elem_id, data, length || '')) {
						is_valid = false
						success = false
					}
					break;
				case 'URL':
					if (!INPUT_URL(elem_id, data)) {
						is_valid = false
						success = false
					}
					break;
				case 'NULLABLE':
					INPUT_NULLABLE(elem_id, data)
					break;
				case 'JSON':
					if (!INPUT_JSON(elem_id, data)) {
						is_valid = false
						success = false
					}
					break;
				case 'TH_ONLY_NUMBER_SPACE':
					if (!INPUT_TH_ONLY_NUMBER_SPACE(elem_id, data)) {
						is_valid = false
						success = false
					}
					break;
				case 'TH_ONLY':
					if (!INPUT_TH_ONLY(elem_id, data)) {
						is_valid = false
						success = false
					}
					break;
				case 'EN_ONLY_NUMBER_SPACE':
					if (!INPUT_EN_ONLY_NUMBER_SPACE(elem_id, data)) {
						success = false
						is_valid = false
					}
					break;
				case 'EN_ONLY':
					if (!INPUT_EN_ONLY(elem_id, data)) {
						success = false
						is_valid = false
					}
					break;
				case 'SELECT':
					if (!SELECT_REQUIRED(elem_id, data)) {
						success = false
						is_valid = false
					}
					break;
				case 'MOBILE':
					if (!INPUT_MOBILE(elem_id, data)) {
						success = false
						is_valid = false
					}
					break;
				case 'CITIZEN':
					if (!INPUT_CITIZEN(elem_id, data)) {
						success = false
						is_valid = false
					}
					break;
				case 'EMAIL':
					if (!INPUT_EMAIL(elem_id, data)) {
						success = false
						is_valid = false
					}
                    break;
                case 'RADIO':
					if (!INPUT_RADIO(elem_id, data)) {
						success = false
						is_valid = false
					}
                    break;
                case 'NUMERIC_MIN':
                    if (!NUMERIC_MIN(elem_id, data, minlength)) {
                        success = false
                        is_valid = false
                    }
                    break;
                case 'NUMERIC_MAX':
                    if (!NUMERIC_MAX(elem_id, data, maxlength)) {
                        success = false
                        is_valid = false
                    }
                    break;
				default:
					break;
			}
		})
    })
    
    if (callback) {
        callback(success)
    }

	return success
}

const validURL = (url) => {
    const pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i') // fragment locator
    return !!pattern.test(url)
}
const IsValidJSONString = (json) => {
    try {
        JSON.parse(json)
    } catch (e) {
        return false
    }
    return true
}
const valid_INPUT_TH_ONLY_NUMBER_SPACE = (input_val) => {
    const pattern = /^[ก-๙0-9 ().,_/-]+$/i;

    return pattern.test(input_val);
}
const valid_INPUT_TH_ONLY = (input_val) => {
    const pattern = /^[ก-๙]+$/i;

    return pattern.test(input_val);
}
const valid_INPUT_EN_ONLY_NUMBER_SPACE = (input_val) => {
    const pattern = /^[A-Za-z0-9 ().,_/-]+$/i;

    return pattern.test(input_val);
}
const valid_INPUT_EN_ONLY = (input_val) => {
    const pattern = /^[A-Za-z]+$/i;

    return pattern.test(input_val);
}
const valid_INPUT_MOBILE = (elem_id, data) => {
	const phone_number = $(elem_id).val().replace(/-/g, "");
    const lengthphone_number = $(elem_id).val().length;
    const first = phone_number.slice(0, 1);
    const second = phone_number.slice(1, 3);
    const sec1 = phone_number.slice(0, 3);
    const sec2 = phone_number.slice(3, 6);
    const sec3 = phone_number.slice(6, 10);
    const phone_number_sliceconvert = sec1 + '-' + sec2 + '-' + sec3;
    if(first != 0){
        return false
    }
    else {
        if (lengthphone_number < 12) {
            return false
        }
        else {
            $(elem_id).attr("value" , phone_number_sliceconvert);
            return true
        }
    }
}
const valid_INPUT_CITIZEN = (elem_id, data) => {
    const id_no = $(elem_id).val().replace(/-/g, "");
    const lengthid_no = $(elem_id).val().length;
    const sec1 = id_no.slice(0, 1);
    const sec2 = id_no.slice(1, 6);
    const sec3 = id_no.slice(6, 10);
    const sec4 = id_no.slice(10, 12);
    const sec5 = id_no.slice(12, 13);
    if (id_no == "") {
        return false
    } else {
        if (lengthid_no < 17) {
            return false
        } else {
            const citizen_id = $(elem_id).val().replace(/-/g, "");
            var summary = 0;
            const count = parseInt(13);

            for (var i = 0; i < (citizen_id.length - 1); i++) {
            	const condition = citizen_id.substring(0, 1);
                if (condition == '0') {
                    return false;
                } else {
                	summary = summary + (citizen_id.substring(i, i + 1) * (count - i));
                }
            }
            const summary_result = summary;
            const mod_sum = parseInt(summary_result) % parseInt(11);
            const checkdigit = parseInt(11) - parseInt(mod_sum);

            const lastCitizen = citizen_id[citizen_id.length - 1];
            //console.log("ตัวสุดท้ายของเลขบัตร " + lastCitizen);
            //console.log("ตัวสุดของตัวเช็ค " + checkdigit);
            if (checkdigit != lastCitizen) {
                //console.log("เลขบัตรประชาชนไม่ถูกต้อง");
                return false
            } else {
            	//console.log("เลขบัตรประชาชนถูกต้อง");
                return true
            }
        }
    }
}

const valid_INPUT_EMAIL = (elem_id, data) => {
    const pattern = /^([a-z\d_]+(\.[a-z\d_\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    if(!pattern.test(data)){
        return false
    }
    else{
       return true
    }
}