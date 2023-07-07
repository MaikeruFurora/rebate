const BaseModel = {

    countChar:function(val){
        var len = val.value.length;
        if (len >= 500) {
          val.value = val.value.substring(0, 500);
        } else {
          $('.showCountChar').text(len);
        }
    },

    rebateStatus:function(data){
        if(data.status=='A'){
            return 'Approved'
        }else if(data.status=='R'){
            return 'Rejected'
        }else if(data.status=='C'){
            return 'Cancelled'
        }else{
            return 'Open / Pending'
        }
    },
    
    datecheckRange:function(from,to){
        if (from!="" && to!="") {
            if (from>to) {
                // alert("Please select date properly")
                // $("input[name=from]").val('')
                // $("input[name=to]").val('')
            }
        }
    },

    loadToPrint:(url) =>{
      $("<iframe>")                             // create a new iframe element
          .hide()                               // make it invisible
          .attr("src", url)                     // point the iframe to the page you want to print
          .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    },
    popupCenter: function({ url, title, w, h }){
        const dualScreenLeft =
            window.screenLeft !== undefined
                ? window.screenLeft
                : window.screenX;
        const dualScreenTop =
            window.screenTop !== undefined ? window.screenTop : window.screenY;

        const width = window.innerWidth
            ? window.innerWidth
            : document.documentElement.clientWidth
            ? document.documentElement.clientWidth
            : screen.width;
        const height = window.innerHeight
            ? window.innerHeight
            : document.documentElement.clientHeight
            ? document.documentElement.clientHeight
            : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - w) / 2 / systemZoom + dualScreenLeft;
        const top = (height - h) / 2 / systemZoom + dualScreenTop;
        const newWindow = window.open(
            url,
            title,
            `
          scrollbars=yes,
          width=${w / systemZoom}, 
          height=${h / systemZoom}, 
          top=${top}, 
          left=${left}
          `
        );
        newWindow;
    },

    modalDetail:   $("#staticBackdrop"),
     _holdHTML:    '',
     _token:       $("meta[name='_token']").attr("content"),
     _ucategory:   $("meta[name='_ucategory']").attr("content"),
     userIdentity: $("meta[name='userIdentity']").attr("content"),
     positionID:   $("meta[name='positionID']").attr("content"),
     leaders:      $("meta[name='leaders']").attr("content"),
     editModal:    $("#editModal"),
     dateRangeModal:$("#dateRangeModal"),
     userAR: new Array(177,185), // AR TEAM (ASSOCIATE & TEAM LEADER)

     checkIfEmptyRebate:(rebAmnt) => {

        (parseFloat(rebAmnt)==0) ? sweeetAlert("WARNING","Empty Rebate Amount","danger") : false

     },
     inArray:(needle, haystack)  => {

        let length = haystack.length;

        for(let i = 0; i < length; i++) {

            if(haystack[i] == needle) return true;

        }

        return false;

    }
}

$('input').on('click',function(){ $(this).select(); })


const sweeetAlert = (title,text,icon) => Swal.fire({
    title:title,
    text:text,
    icon:icon,
    buttons: true,
    dangerMode: true,
    allowOutsideClick: false,
    allowEscapeKey: false
})
