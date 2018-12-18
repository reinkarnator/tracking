<!-- Form elements -->
<div class="grid_12">

    <div class="module">
        <h2><span><?php echo __("Record editing",null); ?></span></h2>

        <div class="module-body">
            <?php switch ($action){  
             	    case 'add': ?>
                        <form action="<?php echo URL::base(TRUE,TRUE).'admin/'.$type.'/save'; ?>" id="commentForm" method="POST" enctype="multipart/form-data">
                    <?php break; case 'edit': ?>
                        <form action="<?php echo URL::base(TRUE,TRUE).'admin/'.$type.'/'.$id.'-'.$artname.'/preview'; ?>" id="commentForm" method="POST" enctype="multipart/form-data">                
                    <?php break; case 'update': ?>
                        <form action="<?php echo URL::base(TRUE,TRUE).'admin/'.$type.'/'.$id.'-'.$artname.'/update'; ?>" id="commentForm" method="POST" enctype="multipart/form-data">
                        <div>
                            <span class="notification n-success"><?php echo __("Record was changed",null); ?></span>
                        </div>   
                    <?php break; }?> 
                    <p>
                        <label><?php echo __("Date",null); ?></label>
			            <?php switch ($action){ case 'add': ?>
                        <input type="text"  name="date" class="required" style="width:250px;" value="<?php echo date("Y-m-d H:i:s");?>" id="datepicker" onmousedown="getDatePick()" />                     
                        <?php break; case 'edit': case 'update': ?>
                        <input type="text" name="date" class="required" style="width:250px;" id="datepicker" onmousedown="getDatePick()" <?php echo ($category['date'] != '0000-00-00 00:00:00') ? 'value="'.$category['date'].'"' : FALSE; ?> />
                        <?php break; }?> 
                    </p>
                    <p>
                        <label><?php echo __("Location",null); ?></label>
                        <?php switch ($action){  case 'add': ?>  
                         <select class="required" name="location" id="location-select" style="width:250px;">     
    		                <option value=""></option>
    		                <?php
                               if ($locations) {
        		                   foreach ($locations as $cat) {    
        		                      echo '<option value="'.$cat['location'].'">'.$cat['location'].'</option>'; 
        		                   }
                               }
    		                 ?>
                         </select>  
    		             <?php break; case 'edit'; case 'update'; ?>
                            <input type="text" class="required" style="width:200px;" value="<?php echo $category['location'] ?>" name="location" readonly="readonly" />
    		             <?php break; }?>  
    		              
                    </p>
                    <p>
                         <label><?php echo __("Device",null); ?></label>                      
                         <?php switch ($action){  case 'add': ?>  
                         <select class="required" id="device-select" name="device" style="width:250px;">       
                            <option value=""></option>
                            <?php
                               if ($devices) {
                                   foreach ($devices as $dev) {    
                                      echo '<option value="'.$dev['name'].'">'.$dev['name'].'</option>'; 
                                   }
                               }
                             ?>
                         </select>      
                         <?php break; case 'edit'; case 'update'; ?>
                            <input type="text" class="required" style="width:200px;" value="<?php echo $category['device'] ?>" name="device" readonly="readonly" /> 
                         <?php break; }?>      
                    </p>                    
                    <p>
                        <label><?php echo __("Subject",null); ?></label>
			            <?php switch ($action){  case 'add': ?>
                        <input type="text" name="subject" class="required" style="width:200px;" value=""/>
                        <?php break; case 'edit'; case 'update'; ?>
                        <input type="text" name="subject" class="required" style="width:200px;" value="<?php echo $category['subject']; ?>" readonly="readonly" />
                        <?php break; }?> 
                    </p>
                    <p>
                        <label><?php echo __("Description",null); ?></label>
                        <?php switch ($action){  case 'add': ?>
                            <textarea rows="11" cols="50" name="description" class="ckeditor" id="editor1"></textarea>
                        <?php break; case 'edit'; case 'update'; ?>
                            <textarea rows="11" cols="50" name="description" class="ckeditor" id="editor1"><?php echo $category['description']; ?></textarea>
                        <?php break; }?> 
                    </p> 
                    <style type="text/css">
                        #kcfinder_div {
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
                        }
                        .btn-files {
                            padding: 10px 20px;
                            background: #FF9966;
                            color: #fff;
                            border: 0;
                            cursor: pointer;
                        }
                    </style>
                    <script type="text/javascript">
                        function openKCFinder1(textarea) {
                                    var pdfs = $('#pdf-val');
                                    var fls_list = $('#files-list');
                                    var fls = '';
                                    var lnks = '';
                            window.KCFinder = {
                                callBackMultiple: function(files) {
                                    window.KCFinder = null;
                                    for (var i = 0; i < files.length; i++) {
                                        fls += "+++" + files[i];
                                        lnks += "<a href='"+files[i]+"' target='_blank'>file" + i + "</a><br />";
                                    }
                                    pdfs.val(fls);
                                    fls_list.html(lnks);
                                        
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
                    </script>                      
                    <label><?php echo __("File",null); ?></label>
                        <div style="float:left;">
                    <?php switch ($action){  case 'add': ?>    
                          <button onclick="openKCFinder1(this)" type="button" class="btn-files">UPLOAD FILES</button><br />
                          <input type="hidden" name="pdf" id="pdf-val" value="" /><br />
                          </div>
                          <div id="files-list" style="float:left;margin-left: 20px;width:300px;background:#fbfbfb; padding: 20px;border: 1px solid #cecece;"></div>                              
                    <?php break; case 'edit'; case 'update'; ?> 
                          <button onclick="openKCFinder1(this)" type="button" class="btn-files">UPLOAD FILES</button>
                          <input type="hidden" name="pdf" id="pdf-val" value="<?php echo $category['pdf'];?>" />
                          </div>
                          <div id="files-list" style="float:left;margin-left: 20px;width:300px;background:#fbfbfb; padding: 20px;border: 1px solid #cecece;">
                          <?php 
                            $pdf = explode("+++",$category['pdf']);
                            $pdf = array_filter($pdf);
                            $pdf_string = '';
                            foreach ($pdf as $pk => $pdf_files) {
                                $pdf_string .= '<a href="'.$pdf_files.'">file'.$pk.'</a><br />';
                            }
                            echo $pdf_string;
                          ?>  
                        </div>                            
                    <?php break; } ?>
                                                           
                    <br clear="all"  />  
                    <p>
                        <?php switch ($action){  case 'add': ?> 
                        <label><?php echo __("Status",null); ?></label>
                        <select name="status">  
                            <option value="0"><?php echo __("Temporary", NULL); ?></option>
                            <option value="4"><?php echo __("Permanent", NULL); ?></option>  
                        </select>       
                        <?php break; case 'edit';  ?>
                        <select name="status">  
                            <option value="0" <?php echo ($category['status'] == '0') ? 'selected="selected"' : FALSE; ?>>
                                <?php echo __("Temporary", NULL); ?></option>
                            <option value="4" <?php echo ($category['status'] == '4') ? 'selected="selected"' : FALSE; ?>>
                                <?php echo __("Permanent", NULL); ?></option>  
                        </select>   
                         <?php  break; case 'update'; ?>
                        <input type="hidden" value="<?php echo $category['status'];?>" name="status" />
                        <?php break; }?>   
                         
                    </p>
                    <br clear="all"  />
                        <?php switch ($action){  case 'add': ?>        
                        <?php break; case 'edit'; case 'update'; ?>
                        <input type="hidden" value="<?php echo $category['mails'];?>" name="mails" />
                        <?php break; }?>                       
                <fieldset>
                    <input class="submit-green" name="saved" type="submit" value="SUBMIT" />
                </fieldset>
            </form>
        </div> <!-- End .module-body -->

    </div>  <!-- End .module -->
    <div style="clear:both;"></div>
</div> <!-- End .grid_12 -->
<script> 
$('#location-select').change(function(){
    var sel = $(this).val();

        $.ajax({
            type: 'POST',
            url: location.href + '_device',
            data: {location: sel},
            dataType: 'json',
            cache: false,
            success: function(result) {
                var val_dev = '';
                $(result).each(function(vaj){
                    val_dev += '<option value="'+result[vaj]['name']+'">'+ result[vaj]['name'] +'</option>';
                });
                $('#device-select').html(val_dev);
            },
            error: function(error,status) {
                alert(status);
            },
        });   
});
</script>  
