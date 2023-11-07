const rebate_details    = []
const restrictData      = {}
const header            = []
let   docnum            = $("input[name=docnum]")
let   docdate           = $("input[name=docdate]")
let   docstatus         = $("input[name=docstatus]")
let   totalamount       = $("input[name=totalamount]")
let   reference_1       = $("input[name=reference_1]")
let   reference_2       = $("input[name=reference_2]")
let   cardname          = $("input[name=cardname]")
let   detail_1          = $("input[name=detail_1]")
let   detail_2          = $("input[name=detail_2]")
let   comments          = $("textarea[name=comments]")
let   tableDetail       = $(".tbl-details")
let   tableHeader       = $(".tbl-header")
//rebate form
let rebateAmount        = $("input[name=rebateAmount]")
let reference           = $("input[name=reference]")
let reason              = $("input[name=reason]")
let clientname          = $("input[name=clientname]") //$("select[name=clientname]")
let rebateButton        = $("#storeRebateForm button[type=submit]")

// search form
let search              = $("input[name=search]")
let category            = $("select[name=category]")

// rebate balance
let rebateBalance       = $('input[name=rebateBalance]')
let totalRebateAmount   = $(".totalRebateAmount")
let orginalTotalAmount   = $(".orginalTotalAmount")

// const restrictDataFunc    = () => totalAmount.prop('required',restrictData.needamt==1)
const checkZeroBalance  = () => {
    (JSON.parse(category.children(":selected").attr("id")).depOnAmount) ?rebateButton.show() : rebateBalance.val()==0?rebateButton.hide():rebateButton.show()
}
//  $("#storeRebateForm *").prop("disabled", true);
rebateAmount.number( true, 4 );
rebateBalance.number( true, 4 );
totalamount.number( true, 4 );
$("#searchInvoice").on('submit',function(e){

    e.preventDefault()
    $.ajax({
    url:`dashboard/search`,
    type: "POST",
    data: new FormData(this),
    processData: false,
    contentType: false,
    cache: false,
    beforeSend:function(){
        $("#searchForm *").prop("disabled", true);
        $("#storeRebateForm")[0].reset()
        $("#storeRebateForm *").prop("disabled", true);
        $(".table-bordered tbody").html(`<tr><td colspan="5" class="text-center">Loading </td></tr>`);
        clientname.val('')
    }
    }).done(function(data){
        rebate_details.length=0
        rebateBalance.val(data[1][0].r_balance)
        // rebateBalance.val((Math.sign(data[1][0].r_balance)=== 1 && restrictData.needamt==1)?(data[1][0].r_balance):0)
        if (data[0].length>0) {
            docnum.val(data[0][0].docnum)
            docdate.val(data[0][0].docdate)
            docstatus.val(data[0][0].docstatus)
            totalamount.val(data[0][0].totalamount)
            reference_1.val(data[0][0].reference_1)
            reference_2.val(data[0][0].reference_2)
            cardname.val(data[0][0].cardname)
            detail_1.val(data[0][0].detail_1)
            detail_2.val(data[0][0].detail_2)
            comments.val(data[0][0].comments)

            console.log(data[3]);
            tableReference((data[3].length>0) ? data[3] : [],data[2])

            clientname.val((restrictData.typeCode=="EDS" || restrictData.typeCode=="VDS")?'':data[0][0].cardname)
            checkZeroBalance()
            table(data)
            tableForHeader(data[2])
        }else{
            tableDetail.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
            tableHeader.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
            sweeetAlert("Warning","No data available","info")
        }
        reference.val(search.val())
        $("#searchForm *").prop("disabled", false);
        $("#storeRebateForm *").prop("disabled", false);
        clientname.attr("readonly",!(restrictData.typeCode=="EDS" || restrictData.typeCode=="VDS"))
        console.log(!(restrictData.typeCode=="EDS" || restrictData.typeCode=="VDS"));
    }).fail(function (jqxHR, textStatus, errorThrown) {
        $("#storeRebateForm *").prop("disabled", false);
        $("#searchForm *").prop("disabled", false);
        tableDetail.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
        tableHeader.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
        console.log(errorThrown);
    })
})

search.on('input',function(){
    reference.val($(this).val())
})

const table = (data)=>{
    html=``;
    if(data.length>0){
        data[0].forEach(element => {
            rebate_details.push({
                dscription:element.dscription ?? '', quantity:$.number(element.quantity,4) ?? '',itemcode:element.itemcode ?? '',
                priceafvat:$.number(element.priceafvat,4) ?? '', linetotal:$.number(element.linetotal,4) ?? ''
            });
            html+=`
            <tr>
                <td> ${element.dscription ?? ''}</td>
                <td> ${element.itemcode ?? ''}</td>
                <td class="details-format-number"> ${ $.number(element.quantity,4) ?? ''}</td>
                <td class="details-format-number"> ${ $.number(element.priceafvat,4) ?? ''}</td>
                <td class="details-format-number"> ${ $.number(element.linetotal,4) ?? ''}</td>
            </tr>
        `
    });
    }else{
        html=`<tr><td colspan="5" class="text-center">No data available</td></tr>`
    }

    tableDetail.html(html)
}

// reference start code

const tableReference = (datas,refUsed) =>{

    const listRef = refUsed.map(val=>{
        if (val.status=="A" || val.status=="O") {
            return val.reference_1
        }
    })

    const valuesRef = datas.filter(e => listRef.indexOf(e.CVNo) > -1 ? false : true);
    console.log(valuesRef);
    $("#tableReference").DataTable({
        bDestroy: true,
        info: false,
        ordering: false,
        paging: false,
        bFilter: false,
        data: valuesRef,
        columns: [
            { 
                data:null,
                render: function (data, type, row, meta) {
                    // console.log(listRef);
                    // console.log(data);
                    return `<input type="radio" name="attach_ref" value="${data.CVNo}">`;
                }
            },
            { data: "CVNo" },
            { data: "Amount" },
        ]
    })

}

// $("button[name=btnRef]").on("click",function(){
//     let cvno = $("#tableReference tbody > tr > td > input:radio:checked ").$("");
//     $("input[name=reference_1]").val(cvno)
//     $("input[name=rebateAmount]").val()
// })

$("#tableReference").on("click", "input[type=radio]", function() {
    let $tds = $(this).closest('tr').find('td');
    let cvno = $tds.eq(1).text();
    let amount = $tds.eq(2).text();
    $("input[name=reference_1]").val(cvno)
    $("input[name=rebateAmount]").val(amount)
  });

// refrence end code

$("select[name='category']").on('change',function(){
    let catData = JSON.parse(this[this.selectedIndex].id);
    restrictData['needamt']=catData['depOnAmount']
    restrictData['typeCode']=catData['code']
    restrictData['depOnSearch']=catData['depOnSearch']
    $("input[name=search]").attr('placeholder',catData['placeholder']).val('')
    $("#searchInvoice input[name=search]").prop('disabled',(catData['code']==null || catData['code']=='')).val('')
    $("#searchInvoice button").prop('disabled',(catData['code']==null || catData['code']==''))
    reference.attr('readonly',!(catData['code']==null || catData['code']==''))
    if (catData['code']==null) {
        $("#storeRebateForm")[0].reset()
        tableDetail.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
    }
    //reset
    reference.val('')
    tableDetail.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
    tableHeader.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
    $("#storeRebateForm")[0].reset()
    $(".showCountChar").text('0')
    rebate_details.length=0
    rebateBalance.val('')
    totalRebateAmount.text('0')
    orginalTotalAmount.text('0')
    $('#clientnameList').html('');
})

const checkDoneForSearch = () => (docnum.val().length==0) ? sweeetAlert("WARNING","Please search for rebate","danger") : false

const checkIfEmptyRebate = () => (parseFloat(rebateAmount.val())===0) ? sweeetAlert("WARNING","Empty Rebate Amount","danger") : false

const storeRebateForm = () =>{

        const storeRebateForm = $("#storeRebateForm");

        const formData = new FormData(storeRebateForm[0])

        formData.append('rebate_details',JSON.stringify(rebate_details))

        formData.append('category',$("select[name=category]").val())

        $.ajax({

        url:`dashboard/store`,

        type: "POST",

        data:formData,

        processData: false,

        contentType: false,

        cache: false,

        beforeSend:function(){
            $("#storeRebateForm *").prop("disabled", true);
        }
        }).done(function(data){
           if (data.msg) {
                sweeetAlert("Warning",data.msg,"warning")
                $("#storeRebateForm *").prop("disabled", false);
                if (data.result) {
                    rebateBalance.val(data.result.r_balance ?? 0)
                }
                rebateAmount.val(0)
           } else {
                tableDetail.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
                tableHeader.html(`<tr><td colspan="5" class="text-center">No data available</td></tr>`)
                sweeetAlert("Saved","Successfully saved the data","success")
                $("#storeRebateForm *").prop("disabled", false);
                $("#storeRebateForm")[0].reset()
                $("#searchForm *").prop("disabled", false);
                $("input[name=search]").val('').attr('placeholder','Please Select')
                $("select[name=category]").trigger('change').prop("selectedIndex", 0);
                $(".showCountChar").text('0')
                rebate_details.length=0
                rebateBalance.val('')
                totalRebateAmount.text('0')
                orginalTotalAmount.text('0')
           }
        }).fail(function (jqxHR, textStatus, errorThrown) {
            $("#storeRebateForm *").prop("disabled", false);
            console.log(errorThrown);
        })
}

$("#storeRebateForm").on('submit',function(e){
    e.preventDefault();
    if (restrictData.depOnSearch==1) {
        if (checkDoneForSearch() || checkIfEmptyRebate()) {
            checkDoneForSearch()
            checkIfEmptyRebate()
        }else{
            storeRebateForm()
        }
    } else {
        storeRebateForm()
    }
})

rebateAmount.on('input',function(){
        if (restrictData.needamt) {
            $.ajax({
                url:'dashboard/checking',
                type:'POST',
                data:{
                    _token:BaseModel._token,
                    search:search.val(),
                    category:category.val()
                }
            }).done(function(data){
                if (data.msg) {
                    console.log(data.msg);
                } else {
                    rebateBalance.val(data[0][0].r_balance)
                    tableForHeader(data[1])
                }
            }).fail(function (jqxHR, textStatus, errorThrown) {
                console.log(errorThrown);
            })
        }
        if(((parseFloat($(this).val()) < 0) || (rebateBalance.val()<parseFloat($(this).val()))) && restrictData.needamt==1){
            sweeetAlert("WARNING","Rebate amount exceeded the remaining balance ("+rebateBalance.val()+")","warning")
            $(this).select().val(null)
        }
})

reason.on('textarea',function(){
    BaseModel.countChar($(this).val())
})

const tableForHeader = (data) =>{
    let _hold =''
    if (data.length>0) {
        data.forEach(element => {
            _hold+=`<tr class=" ${(element.status=='R')?'bg-secondary text-white':'' } ${(element.status=='C')?'bg-danger text-white':'' }">
                    <td> ${element.docnum ?? ''}</td>
                    <td> ${element.rebateAmount ?? ''}</td>
                    <td> ${element.encodedBy ?? ''}</td>
                    <td> ${element.created_at ?? ''}</td>
                    <td> ${BaseModel.rebateStatus(element)}</td>
                    </tr>`
                });
    }else{
        _hold = `<tr><td colspan="5" class="text-center">No data available</td></tr>`
    }

    let _ttotal = data.reduce(function(total,data){ 
        return total+= ((data.status==='C' || data.status==='R')) ? 0 : parseFloat(data.rebateAmount)
    },0)

    tableHeader.html(_hold);
    totalRebateAmount.text($.number(_ttotal,4))
}

// clientname.select2({
//     tags: true
// });


clientname.on('keyup',function(){ 
    let query = $(this).val();
    let _hold=''
    if(query.length!=1 && (restrictData.typeCode!='EDS'))
    {
        $.ajax({
            url:"dashboard/search/client",
            method:"POST",
            data:{query:query, _token:BaseModel._token},
            success:function(data){
                $('#clientnameList').fadeIn();  
                // $('#clientnameList').html(data);
                if (data.length>0) {
                    _hold =`<ul class="dropdown-menu" style="position: relative; display: inline-block;">`;
                    data.forEach(element => {
                        _hold += `<li class="li-client"><a href="#">${element.cardname}</a></li>`;
                    });
                    // for (let i = 0; i < ((data.length>7)?7:data.length); i++) {
                    //         _hold += `<li><a href="#">${data[i].cardname}</a></li>`;
                    // }
                    _hold += `</ul>`;
                }else{
                    _hold=`<ul class="dropdown-menu" ><li><a href="#">${query}</a></li></ul>`
                }
                $('#clientnameList').html(_hold);
            }
        });
    }else{
        $('#clientnameList').html(_hold);
    }
});

clientname.on('focusout',function(){
    $('#clientnameList').fadeOut(); 
})

$(document).on('click', '.li-client', function(){  
    clientname.val($(this).text());  
    $('#clientnameList').fadeOut();  
}); 