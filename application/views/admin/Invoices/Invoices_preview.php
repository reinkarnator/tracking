<!-- Form elements -->
<div class="grid_12">

    <div class="module">
        <h2><span><?php echo __("Record preview",null); ?></span></h2>

        <div class="module-body">
            <?php if ($action == 'preview') { ?>
            <form action="<?php echo URL::base(TRUE,TRUE).'admin/'.$type.'/'.$id.'-'.$artname.'/approve'; ?>" id="commentForm" method="POST" enctype="multipart/form-data">
                    <div>
                        <span class="notification n-information"><?php echo __("Preview information",null); ?></span>
                    </div>   
            <?php } ?>             
                    <p>
                        <strong><?php echo __("Date",null); ?>:</strong>
                        <span><?php echo ($category['date'] != '0000-00-00 00:00:00') ? $category['date']: FALSE; ?></span>
                        <input type="hidden" name="date" value="<?php echo $category['date']; ?>" />
                    </p>
                    <p>
                        <strong><?php echo __("Location",null); ?>:</strong>
    		            <span><?php echo $category['location']; ?></span>
                        <input type="hidden" name="location" value="<?php echo $category['location']; ?>" />  
                    </p>
                    <p>
                        <strong><?php echo __("Device",null); ?>:</strong>
                        <span><?php echo $category['device']; ?></span> 
                        <input type="hidden" name="device" value="<?php echo $category['device']; ?>" />   
                    </p>                    
                    <p>
                        <strong><?php echo __("Subject",null); ?>:</strong>
                        <span><?php echo $category['subject']; ?></span>
                        <input type="hidden" name="subject" value="<?php echo $category['subject']; ?>" />  
                    </p>
                    <p>
                        <strong><?php echo __("Created by",null); ?>:</strong>
                        <span><?php echo $category['user_added']; ?></span> 
                    </p>   
                    <p>
                        <strong><?php echo __("Date added",null); ?>:</strong>
                        <span><?php echo $category['change_date']; ?></span> 
                    </p>                      
                    <p>
                        <strong><?php echo __("Description",null); ?>:</strong><br />
                        <span><?php echo $category['description']; ?></span> 
                        <input type="hidden" name="description" value="<?php echo $category['description']; ?>" />
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
                    <strong style="float:left;"><?php echo __("Files",null); ?>:</strong>:
                  <div id="files-list" style="float:left;margin-left: 20px;width:300px;background:#fbfbfb; padding: 20px;border: 1px solid #cecece;">
                      <?php 
                        $pdf = explode("+++",$category['pdf']);
                        $pdf = array_filter($pdf);
                        $pdf = array_values($pdf);
                        $pdf_string = '';
                        $pdf_arr = '';
                        foreach ($pdf as $pk => $pdf_files) {
                            $pdf_string .= '<a href="'.$pdf_files.'">file'.$pk.'</a><br />';
                           // $pdf_arr .= '+++'.$pdf_files;
                        }
                        echo $pdf_string;
                      ?>  
                      <input type="hidden" name="pdf" value="<?php echo $category['pdf']; ?>" />
                  </div>
                  <br clear="all" />  
                  <div>&nbsp;</div>
                  <p>
                    <label><strong><?php echo __("Status",null); ?>:</strong></label>  
                    <span>
                        <?php if ($category['status'] == '0') { 
                            echo 'Temporary'; 
                        } elseif($category['status'] == '4') {
                            echo 'Permanent';
                        } elseif($category['status'] == '1') {
                            echo 'Returned';
                        } elseif($category['status'] == '2') {
                            echo 'Blocked';
                        }  ?>
                    </span> 
                    <input type="hidden" name="status" value="<?php echo $category['status']; ?>" />                     
                  </p>                  
                  <?php if ($action != 'view') { ?>
                  <p>
                       <label><strong><?php echo __("Mails",null); ?>:</strong></label>  
                       <?php foreach ($users_list as $key => $user) : ?>
                            <input type="checkbox" name="mails[]" value="<?php echo $user['email']; ?>"><?php echo $user['name']; ?><br />          
                       <?php endforeach; ?>
                  </p> 
                  <?php } else { ?>
                  <p>
                    <label><strong><?php echo __("Mails",null); ?>:</strong></label>   

                    <?php if ($mails_name_list) {
                          foreach ($mails_name_list as $key => $mails) {
                               echo $mails.' ('.$key.')'.'<br />';                         
                           } 
                        }  ?>
                  </p>        
                  <?php } ?>



                  <?php if ($action == 'preview') { ?>                                                                                      
                    <br clear="all"  />  
                    <fieldset>
                        <input class="submit-green" name="saved" type="submit" value="SUBMIT" />
                        <input class="submit-gray"  name="back" onclick="window.location='<?php echo URL::base(TRUE,TRUE);?>admin/<?php echo $type;?>/<?php echo $id;?>-m/edit/'" type="button" value="EDIT" />
                    </fieldset>
                   <?php } ?> 
            </form>
        </div> <!-- End .module-body -->

    </div>  <!-- End .module -->
    <div style="clear:both;"></div>
</div> <!-- End .grid_12 -->
