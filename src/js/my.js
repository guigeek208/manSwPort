function getCheckBox() {
    var arr = new Array();
    var checkboxes = document.getElementsByName("checkbox");
    for (var i=0; i<checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            var res = checkboxes[i].id.split("_")
            if (res[0] in arr) {
                arr[res[0]].push(res[1]);
            } else {
                arr[res[0]] = new Array(res[1]);
            }
        }
    }

    var json = "{"
    var i=1;
    for (var key in arr) {
        json = json + '"'+key+'": '+JSON.stringify(arr[key]);
        if (i != Object.keys(arr).length) {
            json = json + ",";
        }
        i++;
    }
    json = json + "}"
    return json;
}

function parseResults(json) {
    console.log(json);
    var obj = JSON.parse(json);
    for (host in obj) {
        console.log(host);
        for (port in obj[host]) {
            if (obj[host][port] == "1") {
                $('i[ipport="'+host+'-'+port+'"]').removeClass("red-text");
                $('i[ipport="'+host+'-'+port+'"]').addClass("green-text");
                $('i[ipport="'+host+'-'+port+'"]').html("arrow_upward");
                //$('i[ipport="'+host+'-'+port+'"]').removeClass("fa-question");
                //$('i[ipport="'+host+'-'+port+'"]').removeClass("fa-arrow-down");
                //$('i[ipport="'+host+'-'+port+'"]').addClass("fa-arrow-up");
            }
            if (obj[host][port] == "0") {
                $('i[ipport="'+host+'-'+port+'"]').addClass("red-text");
                $('i[ipport="'+host+'-'+port+'"]').removeClass("green-text");
                $('i[ipport="'+host+'-'+port+'"]').html("arrow_downward");
                //$('i[ipport="'+host+'-'+port+'"]').removeClass("fa-question");
                //$('i[ipport="'+host+'-'+port+'"]').removeClass("fa-arrow-up");
                //$('i[ipport="'+host+'-'+port+'"]').addClass("fa-arrow-down");
            }
            console.log(port + " " + obj[host][port]);
        }
    }
}

function getStatus() {
    console.log("STATUS");
    $.ajax({
        type: 'getCheckBox',
        url: 'process.php?action=STATUS'
    })
    .done( function( data ) {
        console.log('done');
        $('#modal-refresh').modal('close');
        parseResults(data);
    })
    .fail( function( data ) {
        console.log('fail');
    });
}

function changePortState(state) {
    console.log(state);
    json = getCheckBox();
    //console.log(json);
    $.ajax({
        type: 'POST',
        url: 'process.php?action='+state,
        data: {json: json},
        //dataType: 'json'
    })
    .done( function( data ) {
        console.log('done');
        $('#modal-refresh').modal('close');
        parseResults(data);
    })
    .fail( function( data ) {
        console.log('fail');
        //console.log(data);
    });
}

 $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });

  $(".button-collapse").sideNav();