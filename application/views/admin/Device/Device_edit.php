<!-- Form elements -->
<div class="grid_12">
    <div class="module">
        <h2><span><?php echo __("Company editing",null); ?></span></h2>

        <div class="module-body">
            <?php switch ($action){  
             	  case 'add': ?>
            <form action="<?php echo URL::base(TRUE,TRUE).'admin/'.$type.'/save'; ?>" id="commentForm" method="POST" enctype="multipart/form-data">
            <?php break; case 'edit': ?>
            <form action="<?php echo URL::base(TRUE,TRUE).'admin/'.$type.'/'.$id.'-'.$artname.'/update'; ?>" id="commentForm" method="POST" enctype="multipart/form-data">
            <?php break; case 'update': ?>
            <form action="<?php echo URL::base(TRUE,TRUE).'admin/'.$type.'/'.$id.'-'.$artname.'/update'; ?>" id="commentForm" method="POST" enctype="multipart/form-data">
                                    <div>
                                        <span class="notification n-success"><?php echo __("Company was changed",null); ?></span>
                                    </div>   
            <?php break; }?>  
                    <p>
                        <label><?php echo __("Name",null); ?></label>
			             <?php switch ($action){ case 'add': ?>
                        <input type="text" id="cname" name="name" class="required" style="width:250px;" value="" />
                        <?php break; case 'edit': case 'update': ?>
                        <input type="text" id="cname" name="name" class="required" style="width:250px;" value="<?php echo $category['name']; ?>" />
                        <?php break; }?> 
                    </p>
                    <p>
                        <label><?php echo __("Location",null); ?></label>
                         <?php switch ($action){ case 'add': ?>
                        <input type="text" id="cname" name="location" class="required" style="width:250px;" value="" />
                        <?php break; case 'edit': case 'update': ?>
                        <input type="text" id="cname" name="location" class="required" style="width:250px;" value="<?php echo $category['location']; ?>" />
                        <?php break; }?> 
                    </p>                    
                    <br clear="all" />
                    <fieldset>
                        <input class="submit-green" name="saved" type="submit" value="Submit" />
                        <input class="submit-gray"  name="back" onclick="window.location='<?php echo URL::base(TRUE,TRUE);?>admin/<?php echo $type;?>/'" type="button" value="Back" />
                    </fieldset>
            </form>
        </div> <!-- End .module-body -->

    </div>  <!-- End .module -->
    <div style="clear:both;"></div>
</div> <!-- End .grid_12 -->
