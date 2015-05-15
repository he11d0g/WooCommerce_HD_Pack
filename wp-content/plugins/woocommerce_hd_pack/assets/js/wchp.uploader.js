jQuery(document).ready(function() {
    //uploading files variable
    var custom_file_frame;
    jQuery(document).on('click', '.wchp_test_media', function(event) {
        event.preventDefault();
        //If the frame already exists, reopen it
        if (typeof(custom_file_frame)!=="undefined") {
            custom_file_frame.close();
        }

        //Create WP media frame.
        custom_file_frame = wp.media.frames.customHeader = wp.media({
            //Title of media manager frame
            title: "Sample title of WP Media Uploader Frame",
            library: {
                type: 'image'
            },
            button: {
                //Button text
                text: "insert text"
            },
            //Do not allow multiple files, if you want multiple, set true
            multiple: true
        });

//Callback for selected image
        custom_file_frame.on('select', function() {
            var selection = custom_file_frame.state().get('selection');
            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                var i_view = '<div class="hd_image_thumb" style="float:left;padding:5px" data-url="'+attachment.url+'"><div><img src="'+attachment.url+'" width="100" height="100"></div><input type="hidden" name="wchp_cat_images[]" value="'+attachment.url+'"></div>';
                jQuery('.hd_image_list').append(i_view);
                // Do something else with attachment object
            });
        });


        //custom_file_frame.on('select', function() {
        //    var attachment = custom_file_frame.state().get('selection').first().toJSON();
        //    //do something with attachment variable, for example attachment.filename
        //    //Object:
        //    //attachment.alt - image alt
        //    //attachment.author - author id
        //    //attachment.caption
        //    //attachment.dateFormatted - date of image uploaded
        //    //attachment.description
        //    //attachment.editLink - edit link of media
        //    //attachment.filename
        //    //attachment.height
        //    //attachment.icon - don't know WTF?))
        //    //attachment.id - id of attachment
        //    //attachment.link - public link of attachment, for example ""http://site.com/?attachment_id=115""
        //    //attachment.menuOrder
        //    //attachment.mime - mime type, for example image/jpeg"
        //    //attachment.name - name of attachment file, for example "my-image"
        //    //attachment.status - usual is "inherit"
        //    //attachment.subtype - "jpeg" if is "jpg"
        //    //attachment.title
        //    //attachment.type - "image"
        //    //attachment.uploadedTo
        //    attachment.url
        //    //attachment.width
        //});

        //Open modal
        custom_file_frame.open();
    });


    jQuery(document).on('click','.hd_image_thumb',function(){
        jQuery(this).remove();
    });
});