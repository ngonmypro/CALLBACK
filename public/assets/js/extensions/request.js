function webRequest(method, url, data, callback, headers = null) {
    $.ajax({
        type: method,
        url,
        headers,
        datatype : "application/json",
        data,
        error: function(err) {
            callback(err, null)
        },
        success: function(result) {
            callback(null, result)
        }
    });
}