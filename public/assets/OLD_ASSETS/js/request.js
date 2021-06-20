function webRequest(method, url, data, callback)
{
    $.ajax({
        type: method,
        url,
        datatype : "application/json",
        data,
        error: callback,
        success: callback
    });
}