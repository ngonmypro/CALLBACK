// auto find current relate menu
$(document).ready(function() {

    $('a.menu-items').on('click', function() {
        const menu = $(this).data('menu') || $(this).data('menu-parent') || $(this).data('menu-child')
        const href = $(this).attr('href')
        // console.log({ menu, href, valid: leftmenu.isURL(href) })

        if (leftmenu.isURL(href)) {
            sessionStorage.setItem('lastClick', href)
        }
    })

    leftmenu.menuFocus()

})

const leftmenu = {}

leftmenu.isURL = (url) => {
    try {
        const orig = new URL(url).origin
        if (orig !== null && orig !== 'null') {
            return true
        } else {
            return false
        }
    } catch (e) {
        // console.error('error: ', e)
        return false
    }
}

leftmenu.menuFocus = () => {

    const __url = sessionStorage.getItem('lastClick')

    if (__url !== '' && __url !== null && typeof __url !== 'undefined' && __url.includes(window.location.pathname.split('/')[1])) { 
        const elem = $(`*a[href="${__url}"]`)       
        $(elem).first().addClass('active')
        // console.log($(elem))

        const parentMenu = $(elem).data('menu-parent') || $(elem).data('menu-child') || $(elem).data('menu')
        try {
            $(`*a[data-menu-parent=${parentMenu}]`).first().trigger('click')
        } catch (e) {
            // console.error('error: ', e)
        }
    } else {
        $(`*a[href="${window.location.href}"]`).first().addClass('active')
        $(`*a[href="${window.location.href}"]`).closest(".nav-item.active").find("div.collapse").addClass("show");
        $(`*a[href="${window.location.href}"]`).closest(".nav-item.active").find("a").attr("aria-expanded" , "true");
    }
}


// Static detect left sidebar check URL active tab
let CurrentUrl = window.location.href;
let splitUrl = CurrentUrl.split('/');
let arr = splitUrl;
let getpos3 = CurrentUrl.split('/')[3];
let getpos4 = CurrentUrl.split('/')[4];
let getpos5 = CurrentUrl.split('/')[5];

// console.log(getpos3)
// console.log(getpos4)
// console.log(getpos5)
if(getpos3 == "home"){

    $("#sidenav-collapse-main").find(".nav-item[menu-group='dashboard']").addClass("active")
    $("#sidenav-collapse-main").find(".nav-item[menu-group='dashboard']").children().addClass("active")
}
if(getpos3 == "home" || getpos3 == "dashboard"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='dashboard']").addClass("active")
    $("#sidenav-collapse-main").find(".nav-item[menu-group='dashboard']").children().addClass("active")
    // localStorage.setItem("navigator", "");
    localStorage.setItem("navigator", "dashboard");
}
else if(getpos3 == "UserManagement"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='user']").addClass("active")
    $("#sidenav-collapse-main").find(".nav-item[menu-group='user']").children().addClass("active")
}
else if(getpos3 == "PaymentTransaction"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='payment']").addClass("active")
    $("#sidenav-collapse-main").find(".nav-item[menu-group='payment']").children().addClass("active")
    // localStorage.setItem("navigator", "");
    localStorage.setItem("navigator", "PaymentTransaction");
}
else if(getpos3 == "Corporate" && (getpos4 !==  "Agent" || getpos4 !== "Corporate") ){
    if(getpos4 !== "Setting"){
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").addClass("active")
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").children().addClass("active")
    }
    else{
        // alert("Fggfg")
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").addClass("active");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").children("a").removeClass("collaped");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").children("a").attr("aria-expanded" , "true");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").children("div.collapse").addClass("show");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").children("div.collapse").find("ul.nav").children().first().addClass("active");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").children("div.collapse").find("ul.nav").children().first().find("a").addClass("active");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='corporates']").children("div.collapse").find("ul.nav").first().addClass("show");
    }
    
}
else if(getpos3 == "Agents"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='agent']").addClass("active")
    $("#sidenav-collapse-main").find(".nav-item[menu-group='agent']").children().addClass("active")
    // localStorage.setItem("navigator", "");
    localStorage.setItem("navigator", "Agents");
}
else if(getpos3 == "Recipient"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='recipient']").children("a").removeClass("collaped");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='recipient']").children("a").attr("aria-expanded" , "true");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='recipient']").children("div.collapse").addClass("show");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='recipient']").children("div.collapse").find("li.nav-item").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='recipient']").children("div.collapse").find("li.nav-item > a").addClass("active");
    // localStorage.setItem("navigator", "");
    localStorage.setItem("navigator", "Recipient");
}
else if(getpos3 == "ETax"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("a").removeClass("collaped");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("a").attr("aria-expanded" , "true");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("div.collapse").first().find("li.nav-item").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("div.collapse").first().find("li.nav-item > a").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("div.collapse").addClass("show");
    // localStorage.setItem("navigator", "");
    localStorage.setItem("navigator", "ETax");
}
else if(getpos3 == "FieldMapping"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("a").removeClass("collaped");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("a").attr("aria-expanded" , "true");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("div.collapse").last().find("li.nav-item").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("div.collapse").last().find("li.nav-item > a").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='etax']").children("div.collapse").addClass("show");
    
}
else if(getpos3 == "Bill"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='bill']").children("a").removeClass("collaped");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='bill']").children("a").attr("aria-expanded" , "true");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='bill']").children("div.collapse").find("li.nav-item").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='bill']").children("div.collapse").find("li.nav-item > a").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='bill']").children("div.collapse").addClass("show");
    // localStorage.setItem("navigator", "");
}
else if(getpos3 == "Support"){
    if(getpos4 == "Bill" && getpos5 == undefined){
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("a").removeClass("collaped");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("a").attr("aria-expanded" , "true");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("div.collapse").addClass("show");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("div.collapse").find("ul.nav").children().first().addClass("active");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("div.collapse").find("ul.nav").children().first().find("a").addClass("active");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("div.collapse").find("ul.nav").first().addClass("show");
        // localStorage.setItem("navigator", "");
    }
    else if(getpos4 == "Bill" && getpos5 == "Activity"){
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("a").removeClass("collaped");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("a").attr("aria-expanded" , "true");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("div.collapse").addClass("show");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("div.collapse").find("ul.nav").children().last().addClass("active");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("div.collapse").find("ul.nav").children().last().find("a").addClass("active");
        $("#sidenav-collapse-main").find(".nav-item[menu-group='support']").children("div.collapse").find("ul.nav").last().addClass("show");

        // localStorage.setItem("navigator", "");
    }
    
}
else if(getpos3 == "Loan"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='loan']").children("a").removeClass("collaped");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='loan']").children("a").attr("aria-expanded" , "true");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='loan']").children("div.collapse").find("li.nav-item").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='loan']").children("div.collapse").find("li.nav-item > a").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='loan']").children("div.collapse").addClass("show");
    // localStorage.setItem("navigator", "");
}
else if(getpos3 == "report" &&  getpos4 == "corporate"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("a").removeClass("collaped");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("a").attr("aria-expanded" , "true");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").first().find("li.nav-item").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").first().find("li.nav-item > a").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").first().addClass("show");
    // localStorage.setItem("navigator", "");
}
else if(getpos3 == "report" && getpos4 == "bill"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("a").removeClass("collaped");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("a").attr("aria-expanded" , "true");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").children().eq(1).find("li.nav-item").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").children().eq(1).find("li.nav-item > a").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").children().eq(1).addClass("show");
    // localStorage.setItem("navigator", "");
}
else if(getpos3 == "report" && getpos4 == "payment"){
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("a").removeClass("collaped");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("a").attr("aria-expanded" , "true");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").last().find("li.nav-item").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").last().find("li.nav-item > a").addClass("active");
    $("#sidenav-collapse-main").find(".nav-item[menu-group='report']").children("div.collapse").find("ul.nav").last().addClass("show");
    // localStorage.setItem("navigator", "");
}
else if(getpos3 == "RoleManagement"){
    
    if(getpos4 == "Agent" ){
        if(localStorage.getItem("navigator") == "role_agent"){
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").addClass("active")
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").removeClass("collaped");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").attr("aria-expanded" , "true");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").addClass("show");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("li.nav-item").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("a").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).addClass("show");
            
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("li.nav-item").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("a").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).removeClass("show");
            localStorage.setItem("navigator", "");
            localStorage.setItem("navigator", "role_agent");
        }
        else{
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").addClass("active")
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").removeClass("collaped");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").attr("aria-expanded" , "true");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").addClass("show");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("li.nav-item").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("a").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).addClass("show");
            
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("li.nav-item").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("a").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).removeClass("show");
            localStorage.setItem("navigator", "");
            localStorage.setItem("navigator", "role_agent");
        }
    }
    else if(getpos4 == "Corporate" ){
        if(localStorage.getItem("navigator") == "role_corp"){
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").addClass("active")
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").removeClass("collaped");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").attr("aria-expanded" , "true");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").addClass("show");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("li.nav-item").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("a").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).addClass("show");
            

            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("li.nav-item").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("a").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).removeClass("show");
            localStorage.setItem("navigator", "");
            localStorage.setItem("navigator", "role_corp");
        }
        else{
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").addClass("active")
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").removeClass("collaped");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").attr("aria-expanded" , "true");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").addClass("show");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("li.nav-item").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("a").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).addClass("show");
            

            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("li.nav-item").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("a").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).removeClass("show");
            localStorage.setItem("navigator", "");
            localStorage.setItem("navigator", "role_corp");
        }
    }
    else{
        if(localStorage.getItem("navigator") == "role_agent"){
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").addClass("active")
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").removeClass("collaped");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").attr("aria-expanded" , "true");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").addClass("show");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("li.nav-item").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("a").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).addClass("show");
            
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("li.nav-item").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("a").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).removeClass("show");
            localStorage.setItem("navigator", "");
            localStorage.setItem("navigator", "role_agent");
        }
        else if(localStorage.getItem("navigator") == "role_corp"){
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").addClass("active")
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").removeClass("collaped");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("a").attr("aria-expanded" , "true");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").addClass("show");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("li.nav-item").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).find("a").addClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(0).addClass("show");
            

            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("li.nav-item").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).find("a").removeClass("active");
            $("#sidenav-collapse-main").find(".nav-item[menu-group='role']").children("div.collapse").find("ul.nav").children().eq(1).removeClass("show");
            localStorage.setItem("navigator", "");
            localStorage.setItem("navigator", "role_corp");
        }

    }
    
}
else{

}
