(function() {
    // disabled datatable throw an alert
    $('table').on('error.dt', function ( e, settings, techNote, message ) {
        console.error('An error has been reported by DataTables: ', message)
        e.preventDefault()
        return false
    })

    var origOpen = XMLHttpRequest.prototype.open
    XMLHttpRequest.prototype.open = function() {
        this.addEventListener('load', function() {
            // ajax is completed successfully
            // console.log({ this: this.response })
            ajaxWatcher.handler(this)
        })
        origOpen.apply(this, arguments)
    }
})()

const ajaxWatcher = {
    state: {
        response: null
    },
    handler: function (result) {
        this.set(result)

        let res = null
        try {
            res = JSON.parse(result.response)
        } catch (err) {
            // console.error('error: ', err)
            if (result.response.indexOf('Unauthorized') !== -1) {
                this.dialog()
            }
        }

        if ( (!res.success && res.code && res.code === 401) || (!res.success && res.message && res.message.indexOf('Unauthorized') !== -1) ) {
            this.dialog()
        }
    },
    set: function (data) {
        this.state.response = data
        return
    },
    get: function () {
        return this.state.response
    },
    dialog: function () {
        Swal.fire({
            title: "Session Timeout",
            html: `<p class="py-3 px-1" style="line-height: 2em; letter-spacing: 0.3px;">Due to inactivity past <strong>15</strong> minutes or some reason, your session has been timeout and you must to login again to access your data.</p>`,
            type: "warning",
            showCancelButton: 0,
            buttonsStyling: !1,
            confirmButtonClass: "btn btn-warning",
            confirmButtonText: "SignOut",
            reverseButtons: true
        }).then(function(result) {
            if ( result.value ) {
                window.location.href = '/logout'
            }
        })
    }
}

// OVERRIDE FUNCTION
// ajaxWatcher.handler = function(result) {
//     alert('dfg')
// }
