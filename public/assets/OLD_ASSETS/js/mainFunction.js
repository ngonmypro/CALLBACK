 /*Declare variable*/
 var CheckEventDel = false;
 var CalculateType = "";
/*!
 * Paying
 */
 function submit_bill(){
    window.location = "{!! URL::to('template_invoice') !!}";
}
function EventChecked(SelectedChecked){
    var findPartial = SelectedChecked.parents().eq(1).find(".partial").text();
    var findInvoiceNo = SelectedChecked.parents().eq(1).find(".invoice_number").text();
    var findInvoiceNoID = SelectedChecked.parents().eq(1).find(".invoice_number").attr("id");
    var findTotalAmount = SelectedChecked.parents().eq(1).find(".total_amount").text();
    var TotalAmount = $("#store_sum").val().replace(/,/g, ''); 
    //ตรวจสอบว่าเคยกดลบแล้วหรือยัง
    if(CheckEventDel == true){
        $("#sum_amount").text("");
        $("#store_sum").val("");
    }
    //ตรวจสอบอีเว้นเช็ค
    if(SelectedChecked.is(":checked")){

        // alert("check")
        SelectedChecked.parents().eq(1).css("opacity" , "0.5");

        if(findPartial == 'Yes'){
            
            $(".card-block").append( 
                '<div class="'+findInvoiceNoID+' card-list" style="padding:15px 0px;">'+
                    '<div class="row">'+
                        '<div class="col text-center">'+
                            '<a href="#" class="pull-left del-icon">'+
                                '<i class="zmdi zmdi-close-circle-o text-danger icon-btn"></i>'+
                            '</a>'+
                            '<label>'+findInvoiceNo+'</label>'+
                        '</div>'+
                        '<div class="col text-center">'+
                            '<input type="hidden" name="type[]" value="'+findInvoiceNo+'"/>'+
                            '<input type="text" id="" name="paying['+findInvoiceNo+']" placeholder="ระบุจำนวนเงิน" class="form-control text-right paying numeric paying-'+findInvoiceNo+'">'+
                            '<input type="hidden" name="" value="'+findTotalAmount+'"/>'+
                        '</div>'+
                    '</div>'+
                '</div>');
        }
        else{

            $(".card-block").append( 
                '<div class="'+findInvoiceNoID+' card-list" style="padding:15px 0px;">'+
                    '<div class="row">'+   
                        '<div class="col text-center">'+
                            '<a href="#" class="pull-left del-icon">'+
                                '<i class="zmdi zmdi-close-circle-o text-danger icon-btn"></i>'+
                            '</a>'+
                            '<label>'+findInvoiceNo+'</label>'+
                        '</div>'+
                        '<div class="col text-center">'+
                            '<input type="hidden" name="type[]" value="'+findInvoiceNo+'"/>'+
                            '<input type="text" id="" name="paying['+findInvoiceNo+']" placeholder="ระบุจำนวนเงิน" class="form-control text-right paying numeric not-partial paying-'+findInvoiceNo+'" value="'+findTotalAmount+'" readonly="readonly">'+
                            '<input type="hidden" name="" value="'+findTotalAmount+'"/>'+
                        '</div>'+
                    '</div>'+
                '</div>');
            //ตรวจสอบว่าค่า SUM เป็นค่าว่างหรือไม่ (กรณีที่มีการเลือกค่ามาก่อนหน้าแล้ว เมื่อกดเลือกเพิ่มเติม จะนำผลลัพธ์มาบวกกัน)
            if(TotalAmount != ''){
                 // alert("case 1 ")
                var findTotalAmountRemoveComma = removeComma(findTotalAmount);
                var SumTotal = parseFloat(TotalAmount) + parseFloat(findTotalAmountRemoveComma);

        
                $("#sum_amount").text(addComma(parseFloat(SumTotal).toFixed(2)));
                $("#store_sum").val(removeComma(parseFloat(SumTotal).toFixed(2)));
                
                
            } 
            else{
                 // alert("case 2 ")

                var store_sum = 0;
                var findTotalAmountRemoveComma = removeComma(findTotalAmount);
                var SumTotal = parseFloat(store_sum) + parseFloat(findTotalAmountRemoveComma);
                

                $("#sum_amount").text(addComma(parseFloat(SumTotal).toFixed(2)));
                $("#store_sum").val(removeComma(parseFloat(SumTotal).toFixed(2)));

            }
        }
    }
    else{
         // alert("uncheck")
        SelectedChecked.parents().eq(1).css("opacity" , "1");
         console.log(SelectedChecked);
        //หาตัวที่ถูก append ออกมา
        var FindCardlist = SelectedChecked.parents().eq(5).next();
        console.log(FindCardlist)
        //ลบตัวที่มีค่าเท่ากับตัวที่กด
        var findInputValDel = FindCardlist.find("input.paying-"+findInvoiceNo+"").val();

        console.log("---  " +FindCardlist.find("input.paying-"+findInvoiceNo+"").val());

        if(TotalAmount != ''){
                 // alert("case 1.1 ")

                if(findInputValDel == ''){

                    var SumTotal = parseFloat(TotalAmount) - parseFloat(0);
                    $("#sum_amount").text(addComma(parseFloat(SumTotal).toFixed(2)));
                    $("#store_sum").val(removeComma(parseFloat(SumTotal).toFixed(2)));
                }
                else{
                    var findTotalAmountRemoveComma = removeComma(findInputValDel);
                    var SumTotal = parseFloat(TotalAmount) - parseFloat(findTotalAmountRemoveComma);
                
                    $("#sum_amount").text(addComma(parseFloat(SumTotal).toFixed(2)));
                    $("#store_sum").val(removeComma(parseFloat(SumTotal).toFixed(2)));
                    
                }
                
            }
            else{
                // alert("case 2.2")
            } 
         FindCardlist.find("."+findInvoiceNoID+"").remove();
        
        
    }
 }
 function DisplaySelected(){
    var  CardListLength = $(".card-list").length;
    if(CardListLength != 0){
        console.log(CardListLength);
         console.log("ไม่เท่ากับ 0");
        $("#right-sidebar").removeClass("d-none");
        $("#left-sidebar").removeClass("col-12").addClass("col-8");
    }
    else{
         console.log(CardListLength);
         console.log("เท่ากับ 0");
        // $("#total_invoice").text("0");
        $("#right-sidebar").addClass("d-none");
        $("#left-sidebar").removeClass("col-8").addClass("col-12");
    }
 }

 function reCalculateSum(delValue){
    var sumStore = $("#store_sum").val();
    var findInvoiceNoID = delValue.next().text();
     var FindCardlist = delValue.parents().eq(10).prev();
     var findcheckboxID = FindCardlist.find("."+findInvoiceNoID+"").prev().find("input");
    //หาค่าของตัวที่จะลบ
    var FindInputDelVal = delValue.parents().eq(0).next().find("input.paying").val().replace(/,/g, '');
    var parseFindInputDelVal = parseFloat(FindInputDelVal).toFixed(2);
    
   if(sumStore != '' || sumStore != 'NaN' || sumStore != 'undefined'){
        var calSum = parseFloat(sumStore).toFixed(2) - parseFindInputDelVal;
        
        if(calSum < 0){
            calSum = 0;
            $("#sum_amount").text(addComma(parseFloat(calSum).toFixed(2)));
            $("#store_sum").val(removeComma(parseFloat(calSum).toFixed(2)));
            CheckEventDel = true;
            // alert(calSum)
        }
        else{
            $("#sum_amount").text(addComma(parseFloat(calSum).toFixed(2)));
            $("#store_sum").val(removeComma(parseFloat(calSum).toFixed(2)));
            CheckEventDel = true; 
            // alert(calSum)
        }
        
   }
   else{
        $("#sum_amount").text("");
        CheckEventDel = true;
   }
    delValue.parents().eq(2).remove();
    findcheckboxID.prop("checked" , false);
    FindCardlist.find("."+findInvoiceNoID+"").parent().css("opacity" , "1");
 }

function DelAllValue(delAllValue){
    var findCardBlock = delAllValue.parents().eq(5).next().find(".card-block");
    findCardBlock.empty();
    $("#right-sidebar").addClass("d-none");
    $("#left-sidebar").removeClass("col-8").addClass("col-12");
}
function CalCulatePaying(payingFocus){
    var arrayStore = [];
    var total = parseFloat(0);
    
    $(payingFocus).each(function(index){
        var here = $(this);
        var hereInputVal = here.val().replace(/,/g, '');
        var hereparseIntVal = parseFloat(hereInputVal);
            if(CalculateType == "Confirm_bill_btn"){
                if(here.val() == '' || here.val() == 'NaN'){
                    console.log("invalid");
                    here.addClass("input-invalid");
                    $("#sum_amount").text("");
                    $("#store_sum").val("");
                }
                else{
                    here.removeClass("input-invalid");
                }
            }
            else if(CalculateType == "focus_paying"){
                if(here.val() == '' || here.val() == 'NaN'){
                    console.log("invalid");
                    here.addClass("input-invalid");
                    $("#sum_amount").text("");
                    $("#store_sum").val("");
                }
                else{
                    here.removeClass("input-invalid");
                    arrayStore.push(hereparseIntVal);
                }
                 if(here.val() == '0'){
                    $("#Confirm_bill_btn").attr("disabled" , "disabled");
                }
                else{
                    $("#Confirm_bill_btn").removeAttr("disabled");
                }
            }
             else if(CalculateType == "data-vocher"){
                // alert(CalculateType)
                arrayStore.push(hereparseIntVal);
             }
       });
     if(CalculateType == "Confirm_bill_btn"){
        var store_credit = $("#store_credit").val();
        var store_credit_no = $( ".data-vocher option:selected" ).text();
        var store_sum =    $("#store_sum").val();
        var Total = parseFloat(store_sum).toFixed(2) - parseFloat(store_credit).toFixed(2);
        $(".data-vocher").each(function(index){
            var here = $(this);
            if(here.val() == null){
                console.log("invalid");
                $("#store_credit").val("0")
            }
            else{
                here.removeClass("input-invalid");
                 $(".select_vocher_block").find(".data-vocher").removeClass("input-invalid");
                 $("#store_credit").val(store_credit);
                $( "#store_credit_no" ).val(store_credit_no);
                  // alert(store_credit_no)
                 $("#store_sum").val(Total);
            }
        });
     }
     else if(CalculateType == "focus_paying"){
         //บวกผลลัพธ์
       for(var i =0; i < arrayStore.length;i++){
            var Sum = arrayStore[i];

            total += Sum;
       }
       console.log("total " + total);
       var parseResult = parseFloat(total).toFixed(2);
       //ถ้า กรอกครบแล้ว
       if($("body").find(".input-invalid").length == 0){
            console.log("sum");
            $("#sum_amount").text(addComma(parseFloat(parseResult).toFixed(2)));
            $("#store_sum").val(removeComma(parseFloat(parseResult).toFixed(2)));
        }
        else{
        }
     }
     else if(CalculateType == "data-vocher"){
        // alert(CalculateType);
        //บวกผลลัพธ์
        for(var i =0; i < arrayStore.length;i++){
            var Sum = arrayStore[i];

            total += Sum;
        }
        console.log(arrayStore);
        var parseResult = parseFloat(total).toFixed(2);
        console.log(parseResult)
        $("#sum_credit").text(addComma(parseResult));
        $("#store_credit").val(removeComma(parseResult));
     }
}
function payingFocus(paying){
    var countElem = paying.length;
    var InputVal = paying.val().replace(/,/g, '');
    var parseIntVal = parseFloat(InputVal);
    var findTotalAmount = paying.next().val();
    var removeCommaTotalAmount = parseFloat(removeComma(findTotalAmount)).toFixed(2);
    var ClassTarget = ".paying";

    console.log("parseIntVal " + InputVal);
    console.log("removeCommaTotalAmount " + removeCommaTotalAmount);

    if(parseIntVal > removeCommaTotalAmount){
        // alert("กรอกเกิน")
        paying.val(addComma(removeCommaTotalAmount));
    }

    CalCulatePaying(ClassTarget);
      
}
function ValueMenuChecked(MenuValue , stat){
    var GetVal = $('input[name="statistic"]').val();
    if(GetVal == 'all'){
        MenuValue.find(".statistic__item").addClass("primary-active");
        MenuValue.find(".desc").addClass("title-primary");
        MenuValue.find("i").addClass("title-primary");

        $("a.menu_block").find(".statistic__item").not(this).removeClass("warning-active");
        $("a.menu_block").find(".statistic__item").not(this).removeClass("danger-active");

        $("a.menu_block").find(".desc").not(this).removeClass("title-warning");
        $("a.menu_block").find(".desc").not(this).removeClass("title-danger");

        $("a.menu_block").find("i").not(this).removeClass("title-warning");
        $("a.menu_block").find("i").not(this).removeClass("title-danger");
    }
    else if(GetVal == 'overdue_this_week'){
        MenuValue.find(".statistic__item").addClass("warning-active");
        MenuValue.find(".desc").addClass("title-warning");
        MenuValue.find("i").addClass("title-warning");

        $("a.menu_block").find(".statistic__item").not(this).removeClass("danger-active");
        $("a.menu_block").find(".statistic__item").not(this).removeClass("primary-active");

        $("a.menu_block").find(".desc").not(this).removeClass("danger-active");
        $("a.menu_block").find(".desc").not(this).removeClass("primary-active");

        $("a.menu_block").find("i").not(this).removeClass("danger-active");
        $("a.menu_block").find("i").not(this).removeClass("primary-active");
    }
    else if(GetVal == 'overdue'){
        MenuValue.find(".statistic__item").addClass("danger-active");
        MenuValue.find(".desc").addClass("title-danger");
        MenuValue.find("i").addClass("title-danger");
        $("a.menu_block").find(".statistic__item").not(this).removeClass("warning-active");
        $("a.menu_block").find(".statistic__item").not(this).removeClass("primary-active");

        $("a.menu_block").find(".desc").not(this).removeClass("title-warning");
        $("a.menu_block").find(".desc").not(this).removeClass("title-primary");

        $("a.menu_block").find("i").not(this).removeClass("title-warning");
        $("a.menu_block").find("i").not(this).removeClass("title-primary");
    }
    // console.log(GetVal);
 }
function statistic(stat){
    console.log(stat);
    $("#left-sidebar").removeClass("d-none");
    $('input[name="statistic"]').val(stat)
    oTable.draw();
    // oTable.preventDefault();
}
function search_invoice(){
    $("#left-sidebar").removeClass("d-none");
    oTable.draw();
}
/*!
 * End of Paying
 */
 /*!
 * For Master Layout
 */
function OpenAlertModal(header, body_element , footer)
{
    // Clear data

    //header
    $('#global_modal_alert_header').empty();
    //body
    $('#global_modal_alert_body').empty();
    //footer
    $('#global_modal_alert_footer').empty();

    if(header == "")
    {
        $('#global_modal_alert_header').hide();
    }
    if(body_element == "")
    {
        $('#global_modal_alert_body').hide();
    }
    if(footer == "")
    {
        $('#global_modal_alert_footer').hide();
    }

    $('#global_modal_alert_header').append($.trim(header));
    $('#global_modal_alert_body').append($.trim(body_element));
    $('#global_modal_alert_footer').append($.trim(footer));

    //Toggle modal
    $('#global_modal_alert').modal('toggle');
}

function ModalCloseButtonTemplate(msg , classRef="btn btn-primary standard-outline-primary-btn pt-2 pb-2")
{
    //
    return `<button type="button" class="${classRef}" data-dismiss="modal">${msg}</button>`
}

function CustomButton(element ,  attr  , msg , style='')
{
    //

    if(style === "outline-button"){
        return `<${element} class="btn btn-primary standard-outline-primary-btn pt-2 pb-2" ${attr}>${msg}</${element}>`
    }
    else if(style === "gradient-button"){
        return `<${element} class="btn btn-primary standard-primary-btn pt-2 pb-2" ${attr}>${msg}</${element}>`
    }
    else{
        return `<${element} ${attr}>${msg}</${element}>`
    }
    
}

function CloseAlertModal()
{
    $('#global_modal_alert').modal('hide')
}

function CloseModalCallback(callback)
{
    $('#global_modal_alert').on('hidden.bs.modal', callback)
}

function SetModalAlignDefault()
{
    $('#global_modal_alert .modal-dialog').attr('style', '')
}

function serializeFormJSON(form) {
    var obj = {};
    var arr = form.serializeArray();
    $.each(arr, function () {
        if (obj[this.name]) {
            if (!obj[this.name].push) {
            obj[this.name] = [obj[this.name]]
            }
            obj[this.name].push(this.value || '')
        } else {
        obj[this.name] = this.value || ''
        }
    })
    return obj
}

function FooterProgress( divLevel2Content,footerLevel2Content , optinalBodySection , optinalFooterSection)
{
    if(divLevel2Content == "")
    {
        $('#body_progress').hide();
    }
    if(footerLevel2Content == "")
    {
        $('#footer_progress').hide();
    }
    if(optinalBodySection == "hide")
    {
        $('#body_progress_section').hide();
    }
    if(optinalFooterSection == "hide")
    {
        $('#footer_progress_section').hide();
    }
    //
    $("#body_progress").append($.trim(`${divLevel2Content}`));
    $("#footer_progress").append($.trim(`${footerLevel2Content}`));

}
 //Step Create Corporate
 var Step = $("#page-current").val();
 function AnimateNavigatorStep(){
    
    console.time('timerName');
    $("ul.navigator_step > li").each(function (){
       var aData = $(this).find(".step").data("url");

        if(Step == aData){
            $(this).find("div.rounded-circle").addClass("step-active");
            $(this).find("p").addClass("step-active");

            if(Step == "CorporateProfile"){
                $(this).prev().find("div.rounded-circle").find("span").empty();
                $(this).prev().find("div.rounded-circle").find("span").append('<i class="zmdi zmdi-check" style="margin-left: -5px;font-size: 24px;"></i>');

                $(this).prev().find("div.rounded-circle").addClass("step-active");
                $(this).prev().find("p").addClass("step-active");
            }
            else if(Step == "CreateAdmin"){
                $(this).prev().find("div.rounded-circle").find("span").empty();
                $(this).prev().find("div.rounded-circle").find("span").append('<i class="zmdi zmdi-check" style="margin-left: -5px;font-size: 24px;"></i>');

                $(this).prev().find("div.rounded-circle").addClass("step-active");
                $(this).prev().find("p").addClass("step-active");


                $(this).prev().prev().find("div.rounded-circle").find("span").empty();
                $(this).prev().prev().find("div.rounded-circle").find("span").append('<i class="zmdi zmdi-check" style="margin-left: -5px;font-size: 24px;"></i>');

                $(this).prev().prev().find("div.rounded-circle").addClass("step-active");
                $(this).prev().prev().find("p").addClass("step-active");

            }
            //Crete Role
            else if(Step == "CreatePermission"){
                $(this).prev().find("div.rounded-circle").addClass("step-active");
                $(this).prev().find("p").addClass("step-active");
            }
            //Create User
            else if(Step == "CreateAddNewUser"){
                $(this).prev().find("div.rounded-circle").addClass("step-active");
                $(this).prev().find("p").addClass("step-active");
            }
            //Edit EditRecipient
            else if(Step == "EditRecipient"){
                $(this).next().find("div.rounded-circle").removeClass("step-active");
                $(this).next().find("p").removeClass("step-active");
            }
            //Edit DebtInformation
            else if(Step == "DebtInformation"){
                $(this).prev().find("div.rounded-circle").removeClass("step-active");
                $(this).prev().find("p").removeClass("step-active");
            }
            //Create Recipient
            else if(Step == "CreateRecipient"){
                $(this).next().find("div.rounded-circle").removeClass("step-active");
                $(this).next().find("p").removeClass("step-active");
            }
            //RecipientMasterfile
            else if(Step == "RecipientMasterfile"){
                $(this).prev().find("div.rounded-circle").removeClass("step-active");
                $(this).prev().find("p").removeClass("step-active");
            }
        }
    });
 }
function AdjustFooter(){
    //Check Footer
    var ContentHeight = $(".page-container2").height();
    var BodyHeight = $("body").height();
    if(Step == "SponsorBank"){
        if(ContentHeight < BodyHeight){
            $(".progressbar").removeClass("position-absolute");
            $(".progressbar").addClass("position-fixed");
            $(".progressbar").attr("style" , "left:220px;bottom:0px;");
            $(".progressbar").find(".section__content").addClass("pb-0");
            $(".progressbar").find(".text-progress").addClass("progress-text-05rem");
        }
        else{
            $(".progressbar").addClass("position-absolute");
            $(".progressbar").removeClass("position-fixed");
            $(".progressbar").find(".text-progress").addClass("progress-text-2rem");
        }
    }
    else{
        if(ContentHeight < BodyHeight){
            $(".progressbar").addClass("position-absolute");
            $(".progressbar").attr("style" , "left:220px;bottom:0px;");
            $(".progressbar").find(".section__content").addClass("pb-0");
            $(".progressbar").find(".text-progress").addClass("progress-text-05rem");
        }
        else{
            $(".progressbar").find(".text-progress").addClass("progress-text-2rem");
        }
    }

    $( window ).resize(function() {
        var ContentHeight = $(".page-container2").height();
        var BodyHeight = $("body").height();

        if(Step == "SponsorBank"){
            if(ContentHeight < BodyHeight){
                $(".progressbar").removeClass("position-absolute");
                $(".progressbar").addClass("position-fixed");
                $(".progressbar").attr("style" , "left:220px;bottom:0px;");
                $(".progressbar").find(".section__content").addClass("pb-0");
                $(".progressbar").find(".text-progress").addClass("progress-text-05rem");
                $(".progressbar").find(".text-progress").removeClass("progress-text-2rem");
            }
            else{
                $(".progressbar").addClass("position-absolute");
                $(".progressbar").removeClass("position-fixed");
                $(".progressbar").find(".text-progress").addClass("progress-text-2rem");
                $(".progressbar").find(".text-progress").removeClass("progress-text-05rem");
            }
        }
        else{
            if(ContentHeight < BodyHeight){
                $(".progressbar").addClass("position-absolute");
                $(".progressbar").attr("style" , "left:220px;bottom:0px;");
                $(".progressbar").find(".section__content").addClass("pb-0");
                $(".progressbar").find(".text-progress").addClass("progress-text-05rem");
                $(".progressbar").find(".text-progress").removeClass("progress-text-2rem");
            }
            else{
                $(".progressbar").find(".text-progress").addClass("progress-text-2rem");
                $(".progressbar").find(".text-progress").removeClass("progress-text-05rem");
            }
        }
    });
}
//switch corp
$('.corp_select_switch_item').on('click', function(){
    const ref = $(this).attr('data-switch-corp')
    $('#form_switch_corp input[name=corp_ref]').val(ref)

    $('#form_switch_corp').submit()
});


 /*!
 * End for Master Layout
 */
  /*!
 * For Corporate Management
 */
function BasicInputPatternValidation(element , pattern){
    // console.log(element + pattern);
    var input = element.val();
    var pattern =  pattern;

    if(!pattern.test(input)){
        console.log("invalid pattern " + pattern)
        element.addClass("border-danger");
        element.removeClass("border-success");
    }
    else{
        console.log("success pattern" + pattern)
        element.addClass("border-success");
        element.removeClass("border-danger");
    }

}
  /*!
 * End for Corporate Management
 */