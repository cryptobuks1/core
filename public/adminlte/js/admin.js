$(document).ready(function() {
    $('.error-messages').delay(10000).fadeOut(function(){$(this).remove()});
    $('#checkall').on("click",function() {
        var c = $(".mycheckbox");
        if (c.is(":checked")) {
             $('.mycheckbox').prop('checked', false);
        } else {
             $('.mycheckbox').prop('checked', true);
        }
    });


    /* ================= Toggle Switch - Checkbox ================= */

    $(".Switch").click(function() {
        if( $(this).hasClass("On") ){
            $(this).parent().find("input:checkbox").attr("checked", !1);
            $(this).removeClass("On").addClass("Off");
        }else{
            $(this).parent().find("input:checkbox").attr("checked", !0);
            $(this).removeClass("Off").addClass("On");
        }

    }), $(".Switch").each(function() {
        $(this).parent().find("input:checkbox").length && ($(this).parent().find("input:checkbox").hasClass("show") || $(this).parent().find("input:checkbox").hide(), $(this).parent().find("input:checkbox").is(":checked") ? $(this).removeClass("Off").addClass("On") : $(this).removeClass("On").addClass("Off"))
    });

})

function onDelete(){
	return confirm("Bạn có chắc muốn xóa");
}

/* ================= File Manager ================= */
$(document).ready(function() {
    var bsurl = $('body').attr("bsurl");
    var adminRoute = $('body').attr("adminRoute");
    var cntFiles = null;
    var fm_dropzone = null;

    function showLAFM(type, selector) {
        $("#image_selecter_origin_type").val(type);
        $("#image_selecter_origin").val(selector);

        $("#fm").modal('show');

        loadFMFiles();
    }
    function getLI(upload) {
        var image = '';
        if($.inArray(upload.extension, ["jpg", "jpeg", "png", "gif", "bmp"]) > -1) {
            image = '<img src="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'?s=130">';
        } else {
            switch (upload.extension) {
                case "pdf":
                    image = '<i class="fa fa-file-pdf-o"></i>';
                    break;
                default:
                    image = '<i class="fa fa-file-text-o"></i>';
                    break;
            }
        }
        return '<li><a class="fm_file_sel" data-toggle="tooltip" data-placement="top" title="'+upload.name+'" upload=\''+JSON.stringify(upload)+'\'>'+image+'</a></li>';
    }
    function loadFMFiles() {
        // load uploaded files
        $.ajax({
            dataType: 'json',
            url: $('body').attr("bsurl")+"/"+adminRoute+"/uploads/uploaded_files",
            success: function ( json ) {
                console.log(json);
                cntFiles = json.uploads;
                $(".fm_file_selector ul").empty();
                if(cntFiles.length) {
                    for (var index = 0; index < cntFiles.length; index++) {
                        var element = cntFiles[index];
                        var li = getLI(element);
                        $(".fm_file_selector ul").append(li);
                    }
                } else {
                    $(".fm_file_selector ul").html("<div class='text-center text-danger' style='margin-top:40px;'>No Files</div>");
                }
            }
        });
    }
    // $(".input-group.file input").on("blur", function() {
    //     if($(this).val().startsWith("http")) {
    //         $(this).next(".preview").css({
    //             "display": "block",
    //             "background-image": "url('"+$(this).val()+"')",
    //             "background-size": "cover"
    //         });
    //     } else {
    //         $(this).next(".preview").css({
    //             "display": "block",
    //             "background-image": "url('"+bsurl+"/"+$(this).val()+"')",
    //             "background-size": "cover"
    //         });
    //     }
    // });
    $("#fm input[type=search]").keyup(function () {
        var sstring = $(this).val().trim();
        console.log(sstring);
        if(sstring != "") {
            $(".fm_file_selector ul").empty();
            for (var index = 0; index < cntFiles.length; index++) {
                var upload = cntFiles[index];
                if(upload.name.toUpperCase().includes(sstring.toUpperCase())) {
                    $(".fm_file_selector ul").append(getLI(upload));
                }
            }
        } else {
            loadFMFiles();
        }
    });
    $(".btn_upload_image").on("click", function() {
        showLAFM("image", $(this).attr("selecter"));
    });

    $(".btn_upload_file").on("click", function() {
        showLAFM("file", $(this).attr("selecter"));
    });

    $(".btn_upload_files").on("click", function() {
        showLAFM("files", $(this).attr("selecter"));
    });

    fm_dropzone = new Dropzone("#fm_dropzone", {
        maxFilesize: 2,
        acceptedFiles: "image/*,application/pdf",
        init: function() {
            this.on("complete", function(file) {
                this.removeFile(file);
            });
            this.on("success", function(file) {
                console.log("addedfile");
                console.log(file);
                loadFMFiles();
            });
        }
    });

    $(".uploaded_image i.fa.fa-times").on("click", function() {
        $(this).parent().children("img").attr("src", "");
        $(this).parent().addClass("hide");
        $(this).parent().prev().removeClass("hide");
        $(this).parent().prev().prev().val("0");
    });

    $(".uploaded_file i.fa.fa-times").on("click", function(e) {
        $(this).parent().attr("href", "");
        $(this).parent().addClass("hide");
        $(this).parent().prev().removeClass("hide");
        $(this).parent().prev().prev().val("0");
        e.preventDefault();
    });

    $(".uploaded_file2 i.fa.fa-times").on("click", function(e) {
        var upload_id = $(this).parent().attr("upload_id");
        var $hiddenFIDs = $(this).parent().parent().prev();

        var hiddenFIDs = JSON.parse($hiddenFIDs.val());
        var hiddenFIDs2 = [];
        for (var key in hiddenFIDs) {
            if (hiddenFIDs.hasOwnProperty(key)) {
                var element = hiddenFIDs[key];
                if(element != upload_id) {
                    hiddenFIDs2.push(element);
                }
            }
        }
        $hiddenFIDs.val(JSON.stringify(hiddenFIDs2));
        $(this).parent().remove();
        e.preventDefault();
    });

    $("body").on("click", ".fm_file_sel", function() {
        type = $("#image_selecter_origin_type").val();
        upload = JSON.parse($(this).attr("upload"));
        console.log("upload sel: "+upload+" type: "+type);
        if(type == "image") {
            $hinput = $("input[name="+$("#image_selecter_origin").val()+"]");
            $hinput.val(upload.id);

            $hinput.next("a").addClass("hide");
            $hinput.next("a").next(".uploaded_image").removeClass("hide");
            $hinput.next("a").next(".uploaded_image").children("img").attr("src", bsurl+'/files/'+upload.hash+'/'+upload.name+"?s=150");
        } else if(type == "file") {
            $hinput = $("input[name="+$("#image_selecter_origin").val()+"]");
            $hinput.val(upload.id);

            $hinput.next("a").addClass("hide");
            $hinput.next("a").next(".uploaded_file").removeClass("hide");
            $hinput.next("a").next(".uploaded_file").attr("href", bsurl+'/files/'+upload.hash+'/'+upload.name);
        } else if(type == "files") {
            $hinput = $("input[name="+$("#image_selecter_origin").val()+"]");

            var hiddenFIDs = JSON.parse($hinput.val());
            // check if upload_id exists in array
            var upload_id_exists = false;
            for (var key in hiddenFIDs) {
                if (hiddenFIDs.hasOwnProperty(key)) {
                    var element = hiddenFIDs[key];
                    if(element == upload.id) {
                        upload_id_exists = true;
                    }
                }
            }
            if(!upload_id_exists) {
                hiddenFIDs.push(upload.id);
            }
            $hinput.val(JSON.stringify(hiddenFIDs));
            var fileImage = "";
            if(upload.extension == "jpg" || upload.extension == "png" || upload.extension == "gif" || upload.extension == "jpeg") {
                fileImage = "<img src='"+bsurl+"/files/"+upload.hash+"/"+upload.name+"?s=90'>";
            } else {
                fileImage = "<i class='fa fa-file-o'></i>";
            }
            $hinput.next("div.uploaded_files").append("<a class='uploaded_file2' upload_id='"+upload.id+"' target='_blank' href='"+bsurl+"/files/"+upload.hash+"/"+upload.name+"'>"+fileImage+"<i title='Remove File' class='fa fa-times'></i></a>");
        }
        $("#fm").modal('hide');
    });
});
