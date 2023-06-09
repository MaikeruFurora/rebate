$("#datatable").DataTable({
    processing: true,
    language: {
        processing: `
            <div class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Loading...</span>
        </div>`,
    },

    ajax: `access/list`,
    columns: [
        {
            data:"username"
        },
        {
            data:"catname"
        },
        {
            data:null,
            render:function(data){
                return `<button class="btn btn-sm btn-danger" name="btnRemove" value="${data.id}">Remove</button>`
                console.log(data);
            }
        },
    ]
    
})

$(document).on('click','button[name=btnRemove]',function(){
    let id = $(this).val()
    let _token = $("input[name=_token]").val()
    $.ajax({
        url:'access/remove',
        type:'post',
        data:{
            id, _token
        }
    }).done(function(data){
        window.location.reload();
    }).fail(function(a,b,c){
        alert(b)
    })
})

$("#datatable1").DataTable()

$("select[name=partners]").select2();