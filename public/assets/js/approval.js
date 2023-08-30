const btnGroup      = $(".float-right")
let   rebateAmount  = $("input[name=rebateAmount]")
let   rebateBalance = $("input[name=rebateBalance]")
let   depOnAmount   = $("input[name=depOnAmount]")
const btnRefresh    = $("#btnRefresh")
let clientname      = $("input[name=clientname]")
let category        = $("select[name=category]")
let statuses        = $("select[name=status]")
let start_date      = $("input[name=from]")
let end_date        = $("input[name=to")
                      btnGroup.hide()
const header        = [];
let   id
rebateAmount.number( true, 4 );
rebateBalance.number( true, 4 );
$(document).on('change','input[name="rebateCheckBox"]',function(){
    console.log($(this).val());
    if($(this).is(":checked")){
        header.push($(this).val());
        header.find(val=>val==$(this).val())
    }else{
        let index = header.indexOf($(this).val())   
        header.splice(index,1);
    }
    if (header.length>0) {
        btnGroup.show()
    } else {
        btnGroup.hide()
    }
})

btnRefresh.on('click',function(){
   setTimeout(() => {
        headerDetailTable.ajax.reload()
   }, 2000);
})

// let headerDetailTable = $("#datatable").DataTable({
//         "serverSide": true,

//         createdRow:function( row, data, dataIndex){
            
//             if (data.status=='A') {
//                 $(row).find("td").addClass('highlight-approved');
//             }else if(data.status=='C'){
//                 $(row).find("td").addClass('highlight-cacelled');
//             }else if(data.status=='R'){
//                 $(row).find("td").addClass('highlight-rejected');
//             }
//         },
//         language: {
//             searchPlaceholder: "Search for Reference"
//         },
//         paging:true,
//         "ajax": {
//             url: "approval/list", 
//             method: "get"
//         },
//         order: [[0, 'desc']],
//         columns:[
//             {
//                 data: "updated_at",
//                 target: 0,
//                 visible: false,
//                 searchable: false
//             },
//             {
//                 orderable:false,
//                 data:null,
//                 render:function(data){
//                     if (data.status=='O' && BaseModel._ucategory!="U") {
//                         return `<input type="checkbox" class="form-check" id="" value="${data.id}">`
//                     }
//                     return ''
//                 }
//             },
//             {
//                 orderable: false,
//                 data:"catname"
//             },
           
//             {   
//                  orderable: false,
//                  data:'docdate',
//             },
//             {   
//                 orderable: false,
//                 data:"clientname"
//             },
//             {   
//                 orderable: false,
//                 data:"encodedby"
//             },
//             {   
//                 orderable: false,
//                 data:null,
//                 render:function(data){
//                     return `<span class="badge badge-pill badge-primary">${data.rebateAmount}</spa>`
//                     }
//                 },
//                 {   
//                     orderable: false,
//                 data:"reference"
//             },
//             {   
//                 orderable: false,
//                 data:"reason"
//             },
//             {   
//                  orderable: false,
//                  data:"seriescode"
//             },
//             {   
//                  orderable: false,
//                  data:null,
//                  render:function(data){
//                     return `
//                     <div class="btn-group btn-group-sm" role="group" style="cursor:pointer">
//                     <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" style="font-size:11px" data-toggle="dropdown" aria-expanded="false">
//                             Action&nbsp;&nbsp;<i class="fas fa-caret-down"></i>
//                         </button>
//                         <div class="dropdown-menu" style="font-size:12px">
//                             <a class="dropdown-item details" id="${data.id}"><i class="fas fa-eye"></i> View Details</a>
//                             ${dropdownStatus(data)}
//                         </div>
//                     </div>
//                     `
//                  }
//             },
           
//         ]
// })

let fetchData = (status=null,category=null,clientname=null,start_date,end_date) => {
    $.ajax({
        url: "approval/list",
        type: "get",
        data: {
            status,
            category,
            clientname,
            start_date,
            end_date
        },
        dataType: "json",
        beforeSend:function(){
            $("#datatable").find('tbody').html(`
                <tr><td colspan="11" class="text-center"><div class="spinner-border-sm spinner-border" role="status"> <span class="sr-only">Loading...</span></div></td></tr>
            `)
        }
    }).done(function(data){
        $("#datatable").DataTable({
            // order: [[0, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 1,2,3,4,5,6,7,8,9 ],
                       
                    }
                },
                {
                    extend: 'pdfHtml5',
                    download: 'open',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [ 1,2,3,4,5,6,7,8,9 ],
                        
                    }
                },
            ],
            responsive: true,
            drawCallback: function() {
                const leaders = JSON.parse(BaseModel.leaders)
                const newArr  = leaders.concat(BaseModel.needAccess) 
                let hasRows   = newArr.includes(parseInt(BaseModel.positionID))
                console.log(hasRows);
                $('.buttons-excel')[0].style.visibility = hasRows ? 'visible' : 'hidden'
                $('.buttons-pdf')[0].style.visibility = hasRows ? 'visible' : 'hidden'
            },
            createdRow:function( row, data, dataIndex){
                if (data.status=='A') {
                    $(row).find("td").addClass('highlight-approved');
                }else if(data.status=='C'){
                    $(row).find("td").addClass('highlight-cacelled');
                }else if(data.status=='R'){
                    $(row).find("td").addClass('highlight-rejected');
                }
            },
            bDestroy: true,
            language: {
                searchPlaceholder: "Search for Reference",
                processing: `
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>`,
            },
            deferLoading: 57,
            dataType: "json",
            data: data.list,
            columns:[
                // {
                //     data: "updated_at",
                //     target: 0,
                //     visible: false,
                //     searchable: false
                // },
                {
                    orderable:false,
                    data:null,
                    render:function(data){
                        if (data.status=='O' && BaseModel._ucategory!="U") {
                            return `<input type="checkbox" name="rebateCheckBox" class="form-check" id="" value="${data.hid}">`
                        }
                        return ''
                    }
                },
                {
                    orderable: false,
                    data:"catname"
                },
               
                {   
                     orderable: false,
                     data:'docdate',
                },
                {   
                    orderable: false,
                    data:"clientname",
                },
                {   
                    orderable: false,
                    data:"encodedby"
                },
                {   
                    orderable: false,
                    data:null,
                    render:function(data){
                        return `<span class="badge badge-pill badge-primary">${data.rebateAmount}</spa>`
                        }
                    },
                {   
                    orderable: false,
                    data:"rebateBalance",
                },
                {   
                    orderable: false,
                    data:null,
                    render:function(data){
                        let length = 10;
                        let trimmedString  =  data.reference.length > length ? 
                                            data.reference.substring(0, length - 3) + "..." : 
                                            data.reference;
                        return trimmedString;
                    }
                },
                {   
                    orderable: false,
                    data:"reason",
                    // render:function(data){
                    //     let length = 20;
                    //     let trimmedString  =  data.reason.length > length ? 
                    //                         data.reason.substring(0, length - 3) + "..." : 
                    //                         data.reason;
                    //     return trimmedString;
                    // }
                },
                {   
                     orderable: false,
                     data:"seriescode"
                },
                {   
                     orderable: false,
                     data:null,
                     render:function(data){
                        return `
                        <div class="btn-group btn-group-sm" role="group" style="cursor:pointer">
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" style="font-size:11px" data-toggle="dropdown" aria-expanded="false">
                                Action&nbsp;&nbsp;<i class="fas fa-caret-down"></i>
                            </button>
                            <div class="dropdown-menu" style="font-size:12px">
                                <a class="dropdown-item details" id="${data.hid}"><i class="fas fa-eye"></i> View Details</a>
                                ${dropdownStatus(data)}
                            </div>
                        </div>
                        `
                     }
                },
               
            ]
        })
    }).fail(function(a,b,c){
        alert(c)
    })
}

fetchData('all',null,null, start_date.val(), end_date.val())

 $('#filter').on("click", function(e) {
    e.preventDefault();
    if (start_date.val() == "" || end_date.val() == "") {
        alert("Both date required");
    } else {
        
        $('#datatable').DataTable().destroy();
        fetchData(statuses.val(),category.val(),clientname.val(),start_date.val(), end_date.val());
    }
})

clientname.attr('disabled',true)
category.on('change',function(){
    clientname.val(($(this).val()=="")?"":'').attr('disabled',($(this).val()==""))
})


console.log(BaseModel.positionID);

const dropdownStatus = (data) =>{
    let hold = ''
    switch (true) {
        case (data.status == 'A' && (BaseModel._ucategory=="A" || BaseModel._ucategory=="X" || data.encodedby==BaseModel.userIdentity)):
             hold+= `<a class="dropdown-item dropdown-print" id="${data.hid}"><i class="fas fa-print"></i> Print</a>`;
            break;
        case (data.status == 'A' && BaseModel._ucategory=="A"):
           hold+= `<a class="dropdown-item dropdown-cancel" id="${data.hid}"><i class="fas fa-window-close"></i> Cancel</a>
                   <a class="dropdown-item dropdown-reject" id="${data.hid}"><i class="fas fa-eject"></i> Reject</a>`;
            break;
        case (data.cancelled_at != null):
            return '';
            break;
        case (data.rejected_at != null):
            if(data.encodedby==BaseModel.userIdentity || BaseModel._ucategory=="A" || BaseModel._ucategory=="X"){
                hold+=`<a class="dropdown-item dropdown-edit" id="${data.hid}"><i class="fas fa-edit"></i> Edit</a>`
            }
        break;
        case (data.status=='O' && (BaseModel._ucategory=="A" || BaseModel._ucategory=="X")):
                hold+= `<a class="dropdown-item dropdown-approve" id="${data.hid}"><i class="fas fa-check-circle"></i> Approve</a>
                <a class="dropdown-item dropdown-cancel" id="${data.hid}"><i class="fas fa-window-close"></i> Cancel</a>
                <a class="dropdown-item dropdown-reject" id="${data.hid}"><i class="fas fa-eject"></i> Reject</a>`;
            break;
        case (BaseModel.inArray(BaseModel.positionID,BaseModel.userAR) && (data.status == 'A')):
            hold+= `<a class="dropdown-item dropdown-cm" id="${data.hid}"
                                                         data-rebateAmount="${data.rebateAmount}"
                                                         data-seriescode="${data.seriescode}"
                                                         data-approvedAt="${data.approved_at}"
                                                         data-clientname="${data.clientname}"
                                                         data-dr="${data.reference_1}"
                                                         >
                    <i class="fas fa-file-signature"></i> Credit Memo</a>`;
            break;
        default:
            return ''
            break;
    }

    return hold;
}


const showAlert = (balance,catDependOnAmount) =>{
    if (balance<=0 && catDependOnAmount=='1') {
        BaseModel.editModal.find("span[class='msg']").html(`<div class="alert alert-danger" role="alert">This particular has reached a zero rebate balance.</div>`)
    } else {
        BaseModel.editModal.find("span[class='msg']").html('')
    }
}

$(document).on('click','a.details',function(){
    // alert($(this).attr('id'))
    BaseModel.modalDetail.modal("show")
    BaseModel.modalDetail.find('.modal-title').text('Details')
    BaseModel.modalDetail.find('.modal-footer').html('')
    $.ajax({
    url:`approval/details/${$(this).attr('id')}`,
    type: "GET",
    beforeSend:function(){
        BaseModel.modalDetail.find('.modal-body').html(
            `<div class="text-center"><div class="spinner-border spinner-border-sm text-muted"></div></div>`
        )
    }
    }).done(function(data){
        BaseModel._holdHTML=`<table class="table table-sm table-bordered" style="font-size:11px">`
        console.log(data[1]);
        delete data[0].id
        delete data[0].updated_at
        // delete data[0].reference_1
        // delete data[0].reference_2
        delete data[0].detail_1
        delete data[0].detail_2
        delete data[0].totalamount
        delete data[0].docstatus
        delete data[0].cardname
        delete data[0].docnum
        // delete data[0].created_at
        delete data[0].category_id
        delete data[0].detail
        for(let key in data[0]){
            if (data[0][key]!=null && typeof data[0][key] !== 'object') {
                BaseModel._holdHTML+=`<tr><td><b>${key.toUpperCase()}</b></td><td>${data[0][key]}</td></tr>`
            }
        }
        BaseModel._holdHTML+=`</table>`
        BaseModel._holdHTML+=`<table class="table table-sm mt-2 table-bordered" >`
        BaseModel._holdHTML+=`<thead class="table-dark" style="font-size:11px"><tr><td width="50%">ITEM DESCRIPTION</td><td>ITEM CODE</td><td>QUANTITY</td><td>PRICE</td><td>LINE TOTAL</td></tr></thead>`
        data[1].forEach(element => {
            BaseModel._holdHTML+=`<tr style="font-size:11px"><td>${element.dscription}</td><td>${element.itemcode ?? ''}</td><td>${element.quantity ?? ''}</td><td>${element.priceafvat ?? ''}</td><td>${element.linetotal ?? ''}</td></tr>
            `
        });
        BaseModel._holdHTML+=`</table>`
        console.log(data);
        BaseModel.modalDetail.find('.modal-body').html(BaseModel._holdHTML)
    }).fail(function (jqxHR, textStatus, errorThrown) {
        console.log(errorThrown);
    })
})


const statusAjax = ({holdData,msg}) =>{
    if (confirm(msg)) {
        $.ajax({
            url:holdData.url,
            type:'POST',
            data:{
                header: holdData?.arrId,
                _token: BaseModel._token,
                remarks:holdData?.remarks,
            },
        }).done(function(data){
            console.log(data);
            header.length=0
            // headerDetailTable.ajax.reload()
            $('#datatable').DataTable().destroy();
            fetchData('all',null,null,start_date.val(), end_date.val())

            btnGroup.hide()
            BaseModel.modalDetail.modal("hide")
        }).fail(function (jqxHR, textStatus, errorThrown) {
            console.log(errorThrown);
        })
    }
    
    return false;
}

/*
* 
*
* APPROVED 
* 
*/  


$('.btn-approve').on('click',function(){
    statusAjax({
        holdData:{
            url:`approval/status/approve`,
            arrId: header
        },
        msg: 'Are you sure to approve all selected'
    })
})

$(document).on('click','.dropdown-approve',function(){
    statusAjax({
        holdData:{ 
            url:`approval/status/approve`,
            arrId: new Array($(this).attr('id'))
        },
        msg: 'Are you sure to approve this'
    })
})

/**
 * 
 * 
 * REJECT
 * 
 */


$('.btn-reject').on('click',function(){
    BaseModel.modalDetail.modal("show")
    BaseModel.modalDetail.find('.modal-title').text('Reject Remarks')
    BaseModel._holdHTML=` <textarea class="form-control" name="rejectremarks" placeholder="Required to write a reason" onkeyup="BaseModel.countChar(this)" maxlength="500" rows="4" required></textarea><span class="text-muted"><span class="showCountChar">0</span>/500</span>`
    BaseModel.modalDetail.find('.modal-body').html(BaseModel._holdHTML)
    BaseModel.modalDetail.find('.modal-footer').html(`<button type="submit" class="btn btn-primary btn-submit-reject">Submit</button>`)
})

$(document).on('click','.btn-submit-reject',function(){
    if ($('textarea[name=rejectremarks]').val().length===0) {
        alert("Please give reasons for rejection.")
    } else {
        statusAjax({
             holdData:{
                 url:`approval/status/reject`,
                 remarks:$('textarea[name=rejectremarks]').val(),
                 arrId: header
             },
             msg: 'Are you sure to reject'
        })
    }
})

$(document).on('click','.dropdown-reject',function(){
    header.push($(this).attr('id'))
    BaseModel.modalDetail.modal("show")
    BaseModel.modalDetail.find('.modal-title').text('Reject Remarks')
    BaseModel._holdHTML=` <textarea class="form-control" name="rejectremarks" placeholder="Required to write a reason" onkeyup="BaseModel.countChar(this)" maxlength="500" rows="4" required></textarea><span class="text-muted"><span class="showCountChar">0</span>/500</span>`
    BaseModel.modalDetail.find('.modal-body').html(BaseModel._holdHTML)
    BaseModel.modalDetail.find('.modal-footer').html(`<button type="submit" class="btn btn-primary btn-submit-reject">Submit</button>`)
    //  statusAjax({
    //     holdData:{ 
    //         url:`approval/status/reject`,
    //         arrId: new Array($(this).attr('id'))
    //     },
    //     msg: 'Are you sure to reject'
    // })
})

/*
 * 
 * CANCEL
 * 
 */

 $(document).on('click','.btn-submit-cancel',function(){
    if ($('textarea[name=cancelremarks]').val().length===0) {
        alert("Please give reasons for cancellation.")
    } else {
    statusAjax({
            holdData:{
                url:`approval/status/cancel`,
                remarks:$('textarea[name=cancelremarks]').val(),
                arrId: header
            },
            msg: 'Are you sure to cancel'
    })
    }
})

$(document).on('click','.dropdown-cancel',function(){
    header.push($(this).attr('id'))
    BaseModel.modalDetail.modal("show")
    BaseModel.modalDetail.find('.modal-title').text('Cancel Remarks')
    BaseModel._holdHTML=` <textarea class="form-control" name="cancelremarks" placeholder="Required to write a reason" onkeyup="BaseModel.countChar(this)" maxlength="500" rows="4" required></textarea><span class="text-muted"><span class="showCountChar">0</span>/500</span>`
    BaseModel.modalDetail.find('.modal-body').html(BaseModel._holdHTML)
    BaseModel.modalDetail.find('.modal-footer').html(`<button type="submit" class="btn btn-primary btn-submit-cancel">Submit</button>`)
})

$('.btn-cancel').on('click',function(){
    BaseModel.modalDetail.modal("show")
    BaseModel.modalDetail.find('.modal-title').text('Cancel Remarks')
    BaseModel._holdHTML=` <textarea class="form-control" name="cancelremarks" placeholder="Required to write a reason" onkeyup="BaseModel.countChar(this)" maxlength="500" rows="4" required></textarea><span class="text-muted"><span class="showCountChar">0</span>/500</span>`
    BaseModel.modalDetail.find('.modal-body').html(BaseModel._holdHTML)
    BaseModel.modalDetail.find('.modal-footer').html(`<button type="submit" class="btn btn-primary btn-submit-cancel">Submit</button>`)
})


$(document).on('keyup','textarea[name="cancelremarks"]',function(){
    $(".btn-submit-cancel").prop('disabled',($(this).val().length<0))
})

rebateAmount.on('input',function(){
    if ((parseFloat($(this).val()) < 0) || ((parseFloat($(this).val()) > parseFloat(rebateBalance.val())) && depOnAmount.val()==1)) {
        $(this).addClass('is-invalid').val(0)
    }else{
        $(this).removeClass('is-invalid')

        $.ajax({
            url:'dashboard/checking',
            type:'POST',
            data:{
                _token:BaseModel._token,
                search:BaseModel.editModal.find("input[name=reference]").val(),
                category:BaseModel.editModal.find("input[name=category]").val()
            }
        }).done(function(data){
            BaseModel.editModal.find("input[name=rebateBalance]").val(data[0][0].r_balance)
            showAlert(data[0][0].r_balance<=0, data[1].depOnAmount=='1')
           
        }).fail(function (jqxHR, textStatus, errorThrown) {
            console.log(errorThrown);
        })
    }
    BaseModel.editModal.find("button[name=btnSaveChanges]").prop('disabled',((parseFloat($(this).val()) > parseFloat(rebateBalance.val())) && depOnAmount.val()==1))
})

$(document).on('click','.dropdown-edit',function(){
    BaseModel.editModal.find("span[class='msg']").html('')
    BaseModel.editModal.modal('show')
    BaseModel.editModal.find("h5[id='editModalLabel']").text("Edit")
    $.ajax({
    url:`approval/details/${$(this).attr('id')}`,
    type: "GET",
    }).done(function(data){
        showAlert(data[2][0].r_balance,data[3].depOnAmount)
        // console.log(data[3].depOnAmount);
        if ((Math.abs(data[2][0].r_balance)<=data[0].rebateAmount) && data[3].depOnAmount==1) {
            rebateAmount.addClass('is-invalid')
        } else {
            rebateAmount.removeClass('is-invalid')
        }
        BaseModel.editModal.find("input[name=id]").val(data[0].id)
        BaseModel.editModal.find("input[name=rebateAmount]").val('')
        // BaseModel.editModal.find("input[name=rebateAmount]").val(data[0].rebateAmount).prop('disabled',((Math.abs(data[2][0].r_balance)<=data[0].rebateAmount) && data[3].depOnAmount==1))
        // BaseModel.editModal.find("input[name=docnum]").val(data[0].docnum).prop('disabled',((Math.abs(data[2][0].r_balance)<=data[0].rebateAmount) && data[3].depOnAmount==1))
        BaseModel.editModal.find("input[name=reference]").val(data[0].reference) //.prop('disabled',((Math.abs(data[2][0].r_balance)<=data[0].rebateAmount) && data[3].depOnAmount==1))
        BaseModel.editModal.find("textarea[name=reason]").val(data[0].reason) //.prop('disabled',((Math.abs(data[2][0].r_balance)<=data[0].rebateAmount) && data[3].depOnAmount==1))
        BaseModel.editModal.find("p[class=p-remarks]").text(data[0].rejectremarks)
        BaseModel.editModal.find("input[name=rebateBalance]").val(data[2][0].r_balance)
        BaseModel.editModal.find("input[name=catname]").val(data[3].catname)
        BaseModel.editModal.find("input[name=category]").val(data[3].id)
        BaseModel.editModal.find("input[name=depOnAmount]").val(data[3].depOnAmount)
        BaseModel.editModal.find("button[name=btnSaveChanges]") //.prop('disabled',((Math.abs(data[2][0].r_balance)<=data[0].rebateAmount) && data[3].depOnAmount==1))
    }).fail(function (jqxHR, textStatus, errorThrown) {
        console.log(errorThrown);
    })
})

$("#editForm").on('submit',function(e){
    e.preventDefault()
    if (rebateAmount.val()==0) {
        alert('Warning: Empty Rebate Amount')
    }else{
        $.ajax({
            url:`approval/details/edit/${$("input[name=id]").val()}`,
            type: "POST",
            data:new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
        }).done(function(data){
            if (data.msg) {
                alert(data.msg)
                rebateBalance.val(data.result ?? 0)
                rebateAmount.val(0)
            }else{
                console.log(data);
                BaseModel.editModal.modal('hide')
            }
            // headerDetailTable.ajax.reload()
            $('#datatable').DataTable().destroy();
            fetchData('all',null,null,start_date.val(), end_date.val())
        }).fail(function (jqxHR, textStatus, errorThrown) {
            console.log(errorThrown);
        })
    }
})

$(document).on('click',".dropdown-print",function(){
    let id = $(this).attr('id')
    let url = `approval/details/print/${id}`
    BaseModel.loadToPrint(url)
})


$(document).on('click','.dropdown-cm',function(){
    $("#cmForm")[0].reset()
    console.log($(this).val());
    let amount = $(this).attr("data-rebateAmount")
    $("input[name=approved_at]").val(moment($(this).attr("data-approvedAt")).format('mm/D/yyyy'))
    $("input[name=rebateAmount]").val(amount)
    $("input[name=numbertoword]").val(
        $.spellingNumber(amount, {
            lang: "en",
            wholesUnit: "",
            fractionUnit: "cents",
            digitsLengthW2F: 2,
            decimalSeperator: "and"
        })
    );
    $("input[name=seriescode]").val($(this).attr("data-seriescode"))
    $("input[name=clientname]").val($(this).attr("data-clientname"))
    $("input[name=header]").val($(this).attr("id"))
    $("input[name=dr]").val($(this).attr("data-dr"))
    
    $.ajax({
        url:'approval/details/search/client',
        type:'POST',
        data:{
            _token: BaseModel._token,
            client: $(this).attr("data-clientname")
        }
    }).done(function(data){
        $("textarea[name=address]").val(data.address ?? '')
        $("input[name=tin]").val(data.tin ?? '')
        $("input[name=business_style]").val(data.BusinessStyle ?? '')
    }).fail(function(a,b,c){
        console.log(a,b,c);
    })
    $("#creditMemo").modal("show")
})

