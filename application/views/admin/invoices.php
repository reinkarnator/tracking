<!-- Example table -->
<style>
    .temp-line td {
        background: #ffe19e !important;
        border-bottom: 1px solid #fff;
    }
    #myTable {
   table-layout: fixed;
  border-collapse: collapse;
  width: 100%;   
    }
    td.val-subject {
        white-space: nowrap;
        table-layout:fixed;
        max-width: 150px;
        height: 30px !important;
        overflow: hidden !important;
        padding-right: 10px !important;
    }
    th {
        cursor: pointer;
        background: silver !important;
        color:#fff;
    }
    th:before {
        display: inline;
        content: '▼ ';
    }
    div.result_row {
        display: flex;
        justify-content: space-between;
        /*border-bottom: 2px solid #cecece;
        border-right: 2px solid #cecece;
        border-left: 2px solid #cecece; */
    }
    div.result_row div {
        display: inline-block;
        vertical-align: top;
        padding: 10px 0;
       /* border-right: 2px solid #cecece; */
        text-align: center;
    }  
    .grid_12 {
        position: relative;
    }  
    .srch_btn {
        border: 0;
        color: #fff;
        background: #4AA0B4;
        padding: 4px 20px;
        font-weight: bold;
    }
    /*#resSearch {
        background: #fff;
        position: absolute;
        width: 100%;
    }*/
</style>
<form id="srchform" action="<?php echo URL::base(TRUE,TRUE).'admin/Invoices/search';?>" method="POST" onsubmit="return false;">
<input id="searchInput" autocomplete="off" class="input-long" name="search" value="">
<button type="button" class="srch_btn">Search</button>
<!--<div id="resSearch"></div>-->
</form>
<!--<a id="add-record">Add record</a>-->
<div>&nbsp;</div>
<div class="module">  
  <h2><span><?php echo __("Records list",null); ?></span></h2>
    <div class="module-table-body">
      <form id="testform" method="POST">
        <table id="myTable" class="tablesorter">
          <thead>
                <tr>
                    <th style="width:2%;"><span class="sortvals" id="id" data-val="1">id</span></th>                                     
                    <th style="width:7%"><span class="sortvals" id="date" data-val="1"><?php echo __("Change done at",null); ?></span></th>                                    
                    <th style="width:5%"><span class="sortvals" id="location"  data-val="1"><?php echo __("Location",null); ?></span></th>
                    <th style="width:10%"><span class="sortvals" id="device" data-val="1"><?php echo __("Device",null); ?></span></th>
                    <th style="width:20%"><span class="sortvals" id="subject" data-val="1"><?php echo __("Subject",null); ?></span></th>
                    <th style="width:4%"><span class="sortvals" id="user_added" data-val="1"><?php echo __("Done by",null); ?></span></th>
                    <th style="width:6%"><span class="sortvals" id="change_date" data-val="1"><?php echo __("Record created at",null); ?></span></th>
                    <th style="width:5%"><span class="sortvals" id="status" data-val="1"><?php echo __("Status",null); ?></span></th>
                </tr>
            </thead>
            <tbody id="fbody">
            <?php if (!empty($invoices)) { ?>           
            <?php foreach ($invoices as $indx => $invoice): ?> 
            <?php  
            /*
                if ($invoice['pdf'] != '') { 
                    if (($invoice['pdf'] != '') && (strstr($invoice['pdf'], '+++') !== false)) {

                        $invoice_new1 = explode('+++',$invoice['pdf']);
                        $invoice_new2 = array_filter($invoice_new1);
                        $invoice_new3 = '';
                        foreach ($invoice_new2 as $indx2 => $invoices1) {
                            $invoice_new3 .= '<a href="'.$invoice_new2[$indx2].'" target="_blank">file'.$indx2.'</a><br />';
                        }
                    
                        $invoice_new = $invoice_new3;
                    } else {
                       $invoice_new = '<a href="'.$invoice['pdf'].'" target="_blank">file</a>'; 
                    }    
                      
                } else {
                    $invoice_new = false;
                } 

                if ($invoice['mails']) {
                    $mails1 = str_replace(',','<br />',$invoice['mails']);
                    $mails = $mails1;
                } 
                */
            ?>         
            <?php if ($invoice['status'] == 0) { ?>  
                <tr class="temp-line">
            <?php } else { ?>
                <tr>
            <?php } ?>        
                    <td class="val-id"><?php echo $invoice['id']; ?></td>
                    <td class="val-date"><?php echo $invoice['date']; ?></td>                                    
                    <td class="val-location"><?php echo $invoice['location'];?></td>                                    
                    <td class="val-device"><?php echo $invoice['device']; ?></td>                                    
                    <td class="val-subject"><?php if($invoice['status']=='2') { ?><b style="color:red;">(Closed)</b><?php } ?> <?php echo $invoice['subject']; ?></td>                                                                                                                                                                                 
                    <td align="center"><?php echo $invoice['user_added']; ?></td>                                                                                                         
                    <td align="center"><?php echo ($invoice['change_date'] != '0000-00-00 00:00:00') ? date("Y-m-d", strtotime($invoice['change_date'])) : FALSE ; ?></td>                                                                                                         
                    <td align="center" class="val-status">
                    <?php if (($invoice['user_added'] == Auth::instance()->get_user()->username) && ($invoice['status'] == 0)) { ?>  
                        <a href="<?php echo URL::base(TRUE,TRUE).'admin/Invoices/'.$invoice['id'].'-m/edit';?>"><img src="<?php echo URL::base().'html/admin/images/pencil.gif"'; ?>" width="16" height="16" /></a>
                    <?php } ?>
                        <img src="<?php echo URL::base().'html/admin/images/status'.$invoice['status'].'.png'; ?>" width="16" height="16" />
                        <a class="view-item" data-attr="<?php echo $invoice['id']; ?>" style="cursor:pointer;"><img src="<?php echo URL::base().'html/admin/images/eye.png"'; ?>" width="16" height="16" /></a>
                    <!--<input type="hidden" class="hid-status" value="<?php echo $invoice['status']; ?>" />-->
                    </td>                                                                         
                </tr>              
            <?php endforeach; ?>
            <?php } ?>
            </tbody>
        </table>
      </form>
      <div style="clear: both"></div>
     </div> <!-- End .module-table-body -->
</div> <!-- End .module -->
<div id="dialog" title="View record"></div>  
<style type="text/css">
    /*#kcfinder_div {
        display: none;
        position: absolute;
        width: 670px;
        height: 400px;
        background: #e0dfde;
        border: 2px solid #3687e2;
        border-radius: 6px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        padding: 1px;
        z-index: 1000;
    }*/

</style>
<script>
/*
function openKCFinder1(textarea) {
    window.KCFinder = {
        callBackMultiple: function(files) {
            window.KCFinder = null;
            //if (textarea.value != "") {
                //textarea.value = "+++";
             //   textarea.value = "+++" + textarea.value + "\n";
            //}
            for (var i = 0; i < files.length; i++)
                textarea.value += "+++" + files[i] + "\n";
        }
    };
    var t = "<?php echo URL::base(TRUE); ?>";
    window.open(t +'html/admin/js/ckeditor/kcfinder/browse.php?type=files&dir=files/catalogues',
        'kcfinder_multiple', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=800, height=600'
    );  

    //div.innerHTML = '<iframe name="kcfinder_iframe" src="'+ t +'html/admin/js/ckeditor/kcfinder/browse.php?type=files&dir=files/catalogues" ' +
       // 'frameborder="0" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="no" />';
   // div.style.display = 'block';
}

 $('#add-record').click(function(){
   // var baseurl = '<?php echo URL::base(); ?>';
    var line = '<tr>'
            +'<td></td>'
            +'<td><input type="text" name="date" value=""></td>'                                  
            +'<td><select name="location"><option value=""></option><option value="DBA">DBA</option><option value="DSV">DSV</option><option value="SCV">SCV</option><option value="Landmark 1">Landmark 1</option><option value="Landmark 3">Landmark 3</option><option value="Azercosmos">Azercosmos</option><option value="SPS Tower">SPS Tower</option><option value="SDA">SDA</option><option value="Istiglal">Istiglal</option><option value="AZX">AZX</option><option value="ATS93">ATS93</option></select></td>'                                   
            +'<td><select name="device"><option value=""></option><option value="DBA">DBA</option><option value="DSV">DSV</option><option value="SCV">SCV</option><option value="Landmark 1">Landmark 1</option><option value="Landmark 3">Landmark 3</option><option value="Azercosmos">Azercosmos</option><option value="SPS Tower">SPS Tower</option><option value="SDA">SDA</option><option value="Istiglal">Istiglal</option><option value="AZX">AZX</option><option value="ATS93">ATS93</option></select></td>'                                   
            +'<td><input type="text" name="subject" value=""></td>'                                    
            +'<td><textarea name="description" style="width:300px;height:200px;"></textarea></td>'                                    
            +'<td><input type="checkbox" name="mails[]" value="jb@caspiansat.com">jb@caspiansat.com<br /><input type="checkbox" name="mails[]" value="yr@caspiansat.com">yr@caspiansat.com<br /><input type="checkbox" name="mails[]" value="tr@caspiansat.com">tr@caspiansat.com<br /><input type="checkbox" name="mails[]" value="am@caspiansat.com">am@caspiansat.com<br /><input type="checkbox" name="mails[]" value="sl@caspiansat.com">sl@caspiansat.com</td>'                                    
            +'<td><textarea name="pdf" onclick="openKCFinder1(this)" style="width:300px;height:200px;cursor:pointer"></textarea></td>'                                                                                                         
            +'<td><select name="status"><option value="0">Temporary</option><option value="4">Permanent</option></select></td>'
            +'<td colspan="2"><button style="width:90%;" type="submit" onclick="saveRecord()">SAVE</button></td>'                                                                                                                                                                                            
        +'</tr>';       
    $('#fbody').append(line);
    $('input[name=date]').attr('id','datepicker'); 
    $('input[name=date]').attr('onmousedown','getDatePick()'); 

 });
function editRecord(valit){
    var tr = $(valit).parent().closest('tr');
    var baseurl = "<?php echo URL::base(); ?>";
    var device_val = $('.val-device',tr).html();
    var location_val = $('.val-location',tr).html();
    var status_val = $('.val-status .hid-status',tr).val();
    var file_links = '';
    $('.val-file a',tr).each(function(){
      file_links += '+++'+$(this).attr('href');
    });
     //alert(file_links); 
    //alert(files31);
    if (status_val == '0') {
        //alert($('.val-mails',tr).html());
        //alert(status_val);
        $('.val-date',tr).html('<input type="text" name="date" value="' + $('.val-date',tr).html() + '" />');
        $('.val-location',tr).html('<select name="location"><option value="DBA">DBA</option><option value="DSV">DSV</option><option value="SCV">SCV</option><option value="Landmark 1">Landmark 1</option><option value="Landmark 3">Landmark 3</option><option value="Azercosmos">Azercosmos</option><option value="SPS Tower">SPS Tower</option><option value="SDA">SDA</option><option value="Istiglal">Istiglal</option><option value="AZX">AZX</option><option value="ATS93">ATS93</option></select>');
        $('.val-device',tr).html('<select name="device"><option value="DBA">DBA</option><option value="DSV">DSV</option><option value="SCV">SCV</option><option value="Landmark 1">Landmark 1</option><option value="Landmark 3">Landmark 3</option><option value="Azercosmos">Azercosmos</option><option value="SPS Tower">SPS Tower</option><option value="SDA">SDA</option><option value="Istiglal">Istiglal</option><option value="AZX">AZX</option><option value="ATS93">ATS93</option></select>');
        $('.val-subject',tr).html('<input type="text" name="subject" value="' + $('.val-subject',tr).html() + '" />');
        $('.val-description',tr).html('<textarea name="description" style="width:300px;height:200px;">' + $('.val-description',tr).html() + '</textarea>');
        $('.val-mails',tr).html($('.val-mails',tr).html());
        $('.val-status',tr).html('<a></a>&nbsp;<img src="' + baseurl + 'html/admin/images/status'+ status_val +'.png" width="16" height="16" />');
        $('.val-file',tr).html('<textarea name="pdf" onclick="openKCFinder1(this)" style="width:300px;height:200px;cursor:pointer">' + file_links + '</textarea><div id="kcfinder_div"></div>');
        
        $('.val-status a',tr).attr('onclick','updateRecord(this)').html('<img src="' + baseurl + 'html/admin/images/save.gif" width="16" height="16" />');
        //console.log($('.val-date',tr).html());
        $('select[name=device] option[value="'+device_val+'"]',tr).prop('selected', true);
        $('select[name=location] option[value="'+location_val+'"]',tr).prop('selected', true);
        //$('select[name=status] option[value="'+status_val+'"]',tr).prop('selected', true);
        $('input[name=date]',tr).attr('id','datepicker'); 
        $('input[name=date]',tr).attr('onmousedown','getDatePick()');
    } else if (status_val == '1') {
      //  alert($('.val-mails',tr).html());
        $('.val-date',tr).html('<input type="text" name="date" value="' + $('.val-date',tr).html() + '" />');
        $('.val-location',tr).html(location_val + '<input name="location" type="hidden" value="' + location_val + '" readonly />');
        $('.val-device',tr).html(device_val + '<input name="device" type="hidden" value="' + device_val + '" readonly />');
        $('.val-subject',tr).html($('.val-subject',tr).html() + '<input type="hidden" name="subject" readonly value="' + $('.val-subject',tr).html() + '" />');
        $('.val-description',tr).html('<textarea name="description" style="width:300px;height:200px;">' + $('.val-description',tr).html() + '</textarea>');
        $('.val-mails',tr).html($('.val-mails',tr).html());
        $('.val-status',tr).html('<a></a>&nbsp;<img src="' + baseurl + 'html/admin/images/status'+ status_val +'.png" width="16" height="16" />');
        $('.val-file',tr).html('<textarea name="pdf" onclick="openKCFinder1(this)" style="width:300px;height:200px;cursor:pointer">' + file_links + '</textarea><div id="kcfinder_div"></div>');
        
        $('.val-status a',tr).attr('onclick','updateRecord(this)').html('<img src="' + baseurl + 'html/admin/images/save.gif" width="16" height="16" />');
        //console.log($('.val-date',tr).html());
        //$('select[name=device] option[value="'+device_val+'"]',tr).prop('selected', true);
        //$('select[name=location] option[value="'+location_val+'"]',tr).prop('selected', true);
        //$('select[name=status] option[value="'+status_val+'"]',tr).prop('selected', true);
        $('input[name=date]',tr).attr('id','datepicker'); 
        $('input[name=date]',tr).attr('onmousedown','getDatePick()');        
    }
    //$('select option[]',device_val).html();
}
function updateRecord(val){
    event.preventDefault();

    var tr = $(val).parent().closest('tr');
    var id = $('.val-id',tr).html();
    var url = '/admin/Invoices/'+id+'-m/update';
    var form = $('#testform');

    $.ajax({
        url: url,
        method: 'POST',
        data: form.serialize(),
        success: function(data) {
            console.log(data);
            console.log('serialized');
            $("#testform").load(location.href + " #testform>*", "");
        },
        error: function (request, status, error) {
            console.log(error);
        }
    });
}

function saveRecord(){
    event.preventDefault();
    var url = '/admin/Invoices/save';
    //alert(url);

    var form = $('#testform');
    $.ajax({
        url: url,
        method: 'POST',
        data: form.serialize(),
        success: function(data) {
          //  alert(data);
            console.log('serialized');
            $("#testform").load(location.href + " #testform>*", "");
        },
        error: function (request, status, error) {
            console.log(error);
        }
    });
}
*/
/*
$("#searchInput").keyup(function () {
    //split the current value of searchInput
    var data = this.value.split(" ");
    //create a jquery object of the rows
    var jo = $("#fbody").find("tr");
    if (this.value == "") {
        jo.show();
        return;
    }
    //hide all the rows
    jo.hide();

    //Recusively filter the jquery object to get results.
    jo.filter(function (i, v) {
        var $t = $(this);
        for (var d = 0; d < data.length; ++d) {
            if ($t.is(":contains('" + data[d] + "')")) {
                return true;
            }
        }
        return false;
    })
    //show the rows that match.
    .show();
}).focus(function () {
    this.value = "";
    $(this).css({
        "color": "black"
    });
    $(this).unbind('focus');
}).css({
    "color": "#C0C0C0"
});
*/
$("#searchInput").change(function () {
 //var body_val = $("#fbody").html();
 var srchurl = "<?php echo URL::base(TRUE,TRUE).'admin/Invoices/search';?>";

var search = $("#searchInput").val();
//if (search != '') {
//    console.log(search);
    $.ajax({
    type: "POST",
    url: srchurl,
    data: {"search": search},
    cache: false,                                 
    success: function(response){
      $("#fbody").html(response);
    },
    error: function(response) {
        alert(response);
    } 
    });
    return false;
//} else {
//    $("#fbody").html(body_val);
//}

});


$('.sortvals').click(function() {
    // alert($(this).attr('data-val'));
    var val = $(this).attr("id");
    if (localStorage.getItem('click') == '') {
       localStorage.setItem('click', '1'); 
    }

    //var sts = $(this).attr('data-val');
    if (localStorage.getItem('click') == 0) {
        $.post(location.href,{
            filter: val,
            get_sts: '0'
          }).done(function(data) {
            $('body').html(data);
          }).fail(function() {
            alert( "error" );
        });
        localStorage.setItem('click', '1');
      //  alert(sts);  
    } else {
        $.post(location.href,{
            filter: val,
            get_sts: '1'
          }).done(function(data) {
            $('body').html(data);
          }).fail(function() {
            alert( "error" );
        });
        localStorage.setItem('click', '0');
       // alert(sts); 
    } 


});

</script>  
<script>
$('.view-item').click(function(){
    var view_id = $(this).attr('data-attr');
    var dialog1 = $( "#dialog" ).dialog({ 
          height: 600,
          width: 800
    }); 
    dialog1.load('/admin/Invoices/'+view_id+'-m/view/ .module-body').dialog('open');
});
</script>
