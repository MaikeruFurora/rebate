$("button[name=searchData]").on('click',function(){
    $("#searchData").modal("show")
    tbl([])
})

$("#searchForm").on('submit',function(e){
    $("#searchForm *").prop("readonly", true);
    e.preventDefault()
    $.ajax({
        url:  $(this).attr('action'),
        type:'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend:function(){
            $("#searchForm button").text("Searching...");
        }
    }).done(function(data){
        $("#searchForm *").prop("readonly", false);
        $("#searchForm button").text("Search");
        tbl(data)
    }).fail(function (jqxHR, textStatus, errorThrown) {
        console.log(errorThrown);
        $("#searchForm *").prop("readonly", false);
        $("#searchForm button").text("Search");
    })

})

const tbl = (data) =>{
    $("#datatableSearchData").DataTable({
        bDestroy: true,
        ordering:false,
        responsive: true,
        searching: false, // Disable searchin   g
        // paging: false,    // Disable paging
        createdRow:function( row, data, dataIndex){
            if (data.status=='A') {
                $(row).find("td").addClass('highlight-approved');
            }else if(data.status=='C'){
                $(row).find("td").addClass('highlight-cacelled');
            }else if(data.status=='R'){
                $(row).find("td").addClass('highlight-rejected');
            }
        },
       
        language: {
            searchPlaceholder: "Search for Reference",
            processing: `
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>`,
        },
        deferLoading: 57,
        dataType: "json",
        data: data,
        columns:[
            {   data:"catname" },
           
            {    data:'docdate', },
            {    data:"clientname", },
            {    data:"encodedby" },
            {   
                data:null,
                render:function(data){
                    return `<span class="badge badge-pill badge-primary">${data.rebateAmount}</spa>`
                    }
                },
            {   data:"rebateBalance", },
            {     data:"reference", },
            {     data:"reference_2", },
            {    data:"seriescode" },
           
        ]
    })
}