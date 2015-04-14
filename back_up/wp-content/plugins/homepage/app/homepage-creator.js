(function($) {
    $(document).ready(function() {
        var TRANSITION_EFFECTS = ["fade", "crossfade", "slide", "elastic", "slice", "blinds", "threed", "threedhorizontal", "blocks", "shuffle"];
        var DYNAMIC_POSITIONS = ["topleft", "topright", "bottomleft", "bottomright", "topcenter", "bottomcenter", "centercenter"];
        $(".homepage-engine").css({display: "none"});
        $("#homepage-toolbar").find("li").each(function(index) {
            $(this).click(function() {
                if ($(this).hasClass("homepage-tab-buttons-selected"))
                    return;
                $(this).parent().find("li").removeClass("homepage-tab-buttons-selected");
                if (!$(this).hasClass("laststep"))
                    $(this).addClass("homepage-tab-buttons-selected");
                $("#homepage-tabs").children("li").removeClass("homepage-tab-selected");
                $("#homepage-tabs").children("li").eq(index).addClass("homepage-tab-selected");
                $("#homepage-tabs").removeClass("homepage-tabs-grey");
                if (index == 2) {
                    previewSlider();
                    $("#homepage-tabs").addClass("homepage-tabs-grey")
                } else if (index == 3)
                    publishSlider()
            })
        });
        var getURLParams = function(href) {
            var result = 
            {};
            if (href.indexOf("?") < 0)
                return result;
            var params = href.substring(href.indexOf("?") + 1).split("&");
            for (var i = 0; i < params.length; i++) {
                var value = params[i].split("=");
                if (value && value.length == 2 && value[0].toLowerCase() != "v")
                    result[value[0].toLowerCase()] = value[1]
            }
            return result
        };
        var slideDialog = function(dialogType, onSuccess, data, dataIndex) {
            var dialogTitle = ["image", "video", "Youtube Video", "Vimeo Video", "Text"];
            var dialogCode = "<div class='homepage-dialog-container'>" + "<div class='homepage-dialog-bg'></div>" + 
            "<div class='homepage-dialog'>" + "<h3 id='homepage-dialog-title'></h3>" + "<div class='error' id='homepage-dialog-error' style='display:none;'></div>" + "<table id='homepage-dialog-form'>";
            if (dialogType == 2 || dialogType == 3)
                dialogCode += "<tr>" + "<th>Enter video URL</th>" + "<td><input name='homepage-dialog-video' type='text' id='homepage-dialog-video' value='' class='regular-text' /> <input type='button' class='button' id='homepage-dialog-select-video' value='Enter' /></td>" + "</tr>" + 
                "<tr>";
            if (dialogType != 4)
                dialogCode += "<tr>" + "<th>Enter" + (dialogType > 0 ? " poster" : "") + " image URL</th>" + "<td><input name='homepage-dialog-image' type='text' id='homepage-dialog-image' value='' class='regular-text' /> or <input type='button' class='button' data-textid='homepage-dialog-image' id='homepage-dialog-select-image' value='Upload' /></td>" + "</tr>" + "<tr id='homepage-dialog-image-display-tr' style='display:none;'>" + "<th></th>" + "<td><img id='homepage-dialog-image-display' style='width:80px;height:80px;' /></td>" + 
            "</tr>" + "<tr>" + "<th>Thumbnail URL</th>" + "<td><input name='homepage-dialog-thumbnail' type='text' id='homepage-dialog-thumbnail' value='' class='regular-text' /> or <input type='button' class='button' data-textid='homepage-dialog-thumbnail' id='homepage-dialog-select-thumbnail' value='Upload' /></td>" + "</tr>";
            if (dialogType == 1)
                dialogCode += "<tr>" + "<th>MP4 video URL</th>" + "<td><input name='homepage-dialog-mp4' type='text' id='homepage-dialog-mp4' value='' class='regular-text' /> or <input type='button' class='button' data-textid='homepage-dialog-mp4' id='homepage-dialog-select-mp4' value='Upload' /></td>" + 
                "</tr>" + "<tr>" + "<tr>" + "<th>WebM video URL (Optional)</th>" + "<td><input name='homepage-dialog-webm' type='text' id='homepage-dialog-webm' value='' class='regular-text' /> or <input type='button' class='button' data-textid='homepage-dialog-webm' id='homepage-dialog-select-webm' value='Upload' /></td>" + "</tr>" + "<tr>";
            dialogCode += "<tr>" + "<th>Title</th>" + "<td><input name='homepage-dialog-image-title' type='text' id='homepage-dialog-image-title' value='' class='large-text' /></td>" + 
            "</tr>" + "<tr>" + "<th>Description</th>" + "<td><textarea name='homepage-dialog-image-description' type='' id='homepage-dialog-image-description' value='' class='large-text' /></td>" + "</tr>" + "<tr>" + "<th>Button text</th>" + "<td><div style='float:left;'><input name='homepage-dialog-image-button' type='text' id='homepage-dialog-image-button' value='' class='regular-text' style='width:240px;'/> CSS:&nbsp;&nbsp;&nbsp;&nbsp;</div>" + "<div class='select-editable'><select onchange='this.nextElementSibling.value=this.value'>" + 
            "<option value=''></option>" + "<option value='read_more_cta'>Read more cta</option>"  + "</select><input type='text' name='homepage-dialog-image-buttoncss' id='homepage-dialog-image-buttoncss' value='read_more_cta' /></div>" + "</td>" + "</tr>" + "<tr>" + "<th>Button link</th>" + "<td><input name='homepage-dialog-image-buttonlink' type='text' id='homepage-dialog-image-buttonlink' value='' class='regular-text' style='width:240px;'/> Target: <input name='homepage-dialog-image-buttonlinktarget' type='text' id='homepage-dialog-image-buttonlinktarget' value='' class='small-text' style='width:120px;' /></td>" + 
            "</tr>";
            dialogCode += "<tr>" + "<th>Box size</th>" + "<td><div class='select-editable'><select onchange='this.nextElementSibling.value=this.value'>" +
            "<option value=''></option>" + "<option value='one_block'>One</option>"  + "<option value='two_block'>Two</option>"  + "<option value='three_block'>Three</option>"  + "<option value='four_block'>Four</option>"  +  "</select><input type='text' name='homepage-dialog-boxsize' id='homepage-dialog-boxsize' value='one_block' /></div>" +
            "</td>" + "</tr>";            
            dialogCode += "<tr>" + "<th>Click to open Lightbox popup</th>" + "<td><label><input name='homepage-dialog-lightbox' type='checkbox' id='homepage-dialog-lightbox' value='' /> Open current " + dialogTitle[dialogType] + " in Lightbox</label>" + "<br /><label><input name='homepage-dialog-lightbox-size' type='checkbox' id='homepage-dialog-lightbox-size' value='' /> Set Lightbox size </label>" + " <input name='homepage-dialog-lightbox-width' type='text' id='homepage-dialog-lightbox-width' value='960' class='small-text' /> / <input name='homepage-dialog-lightbox-height' type='text' id='homepage-dialog-lightbox-height' value='540' class='small-text' />" + 
            "</td>" + "</tr>";
            if (dialogType == 0)
                dialogCode += "<tr><th>Click to open web link</th>" + "<td>" + "<input name='homepage-dialog-weblink' type='text' id='homepage-dialog-weblink' value='' class='regular-text' />" + "</td>" + "</tr>" + "<tr><th>Set web link target</th>" + "<td>" + "<input name='homepage-dialog-linktarget' type='text' id='homepage-dialog-linktarget' value='' class='regular-text' />" + "</td>" + "</tr>";
            dialogCode += "</table>" + "<br /><br />" + "<div class='homepage-dialog-buttons'>" + "<input type='button' class='button button-primary' id='homepage-dialog-ok' value='OK' />" + 
            "<input type='button' class='button' id='homepage-dialog-cancel' value='Cancel' />" + "</div>" + "</div>" + "</div>";
            var $slideDialog = $(dialogCode);
            $("body").append($slideDialog);
            $(".homepage-dialog").css({"margin-top": String($(document).scrollTop() + 60) + "px"});
            $(".homepage-dialog-bg").css({height: $(document).height() + "px"});
            $("#homepage-dialog-lightbox").click(function() {
                var is_checked = $(this).is(":checked");
                if ($("#homepage-dialog-weblink").length) {
                    $("#homepage-dialog-weblink").attr("disabled", 
                    is_checked);
                    if (is_checked)
                        $("#homepage-dialog-weblink").val("")
                }
                if ($("#homepage-dialog-linktarget").length) {
                    $("#homepage-dialog-linktarget").attr("disabled", is_checked);
                    if (is_checked)
                        $("#homepage-dialog-linktarget").val("")
                }
                $("#homepage-dialog-lightbox-width").attr("disabled", !is_checked);
                $("#homepage-dialog-lightbox-height").attr("disabled", !is_checked)
            });
            $(".homepage-dialog").css({"margin-top": String($(document).scrollTop() + 60) + "px"});
            $(".homepage-dialog-bg").css({height: $(document).height() + 
                "px"});
            $("#homepage-dialog-title").html("Add " + dialogTitle[dialogType]);
            if (data) {
                if (dialogType == 2 || dialogType == 3)
                    $("#homepage-dialog-video").val(data.video);
                $("#homepage-dialog-image").val(data.image);
                if (data.image) {
                    $("#homepage-dialog-image-display-tr").css({display: "table-row"});
                    $("#homepage-dialog-image-display").attr("src", data.image)
                }
                $("#homepage-dialog-thumbnail").val(data.thumbnail);
                if ($.trim($("#homepage-dialog-image-title").val()).length <= 0)
                    $("#homepage-dialog-image-title").val(data.title);
                $("#homepage-dialog-image-description").val(data.description);
                $("#homepage-dialog-image-button").val(data.button);
                $("#homepage-dialog-image-buttoncss").val(data.buttoncss);
                $("#homepage-dialog-boxsize").val(data.boxsize);
                $("#homepage-dialog-image-buttonlink").val(data.buttonlink);
                $("#homepage-dialog-image-buttonlinktarget").val(data.buttonlinktarget);
                if (dialogType == 1) {
                    $("#homepage-dialog-mp4").val(data.mp4);
                    $("#homepage-dialog-webm").val(data.webm)
                }
                if (dialogType == 0)
                    if (data.lightbox) {
                        $("#homepage-dialog-weblink").attr("disabled", 
                        true);
                        $("#homepage-dialog-linktarget").attr("disabled", true);
                        $("#homepage-dialog-weblink").val("");
                        $("#homepage-dialog-linktarget").val("")
                    } else {
                        $("#homepage-dialog-weblink").val(data.weblink);
                        $("#homepage-dialog-linktarget").val(data.linktarget)
                    }
                $("#homepage-dialog-lightbox").attr("checked", data.lightbox);
                $("#homepage-dialog-lightbox-width").attr("disabled", !data.lightbox);
                $("#homepage-dialog-lightbox-height").attr("disabled", !data.lightbox);
                if ("lightboxsize" in data)
                    $("#homepage-dialog-lightbox-size").attr("checked", 
                    data.lightboxsize);
                if (data.lightboxwidth)
                    $("#homepage-dialog-lightbox-width").val(data.lightboxwidth);
                if (data.lightboxheight)
                    $("#homepage-dialog-lightbox-height").val(data.lightboxheight)
            }
            if (dialogType == 2 || dialogType == 3)
                $("#homepage-dialog-select-video").click(function() {
                    var videoData = {type: dialogType,video: $.trim($("#homepage-dialog-video").val()),image: $.trim($("#homepage-dialog-image").val()),thumbnail: $.trim($("#homepage-dialog-thumbnail").val()),title: $.trim($("#homepage-dialog-image-title").val()),
                        description: $.trim($("#homepage-dialog-image-description").val()),button: $.trim($("#homepage-dialog-image-button").val()), boxsize: $.trim($("#homepage-dialog-boxsize").val()),buttoncss: $.trim($("#homepage-dialog-image-buttoncss").val()),buttonlink: $.trim($("#homepage-dialog-image-buttonlink").val()),buttonlinktarget: $.trim($("#homepage-dialog-image-buttonlinktarget").val())};
                    $slideDialog.remove();
                    onlineVideoDialog(dialogType, function(items) {
                        items.map(function(data) {
                            homepage_config.slides.push({type: dialogType,image: data.image,
                                thumbnail: data.thumbnail ? data.thumbnail : data.image,video: data.video,mp4: data.mp4,webm: data.webm,title: data.title,description: data.description,button: data.button,buttoncss: data.buttoncss,buttonlink: data.buttonlink,buttonlinktarget: data.buttonlinktarget,weblink: data.weblink,linktarget: data.linktarget,lightbox: data.lightbox,lightboxsize: data.lightboxsize,lightboxwidth: data.lightboxwidth,lightboxheight: data.lightboxheight})
                        });
                        updateMediaTable()
                    }, videoData, true, dataIndex)
                });
            var media_upload_onclick = function(event) {
                event.preventDefault();
                var buttonId = $(this).attr("id");
                var textId = $(this).data("textid");
                var media_uploader = wp.media.frames.file_frame = wp.media({title: "Choose Image",button: {text: "Choose Image"},multiple: dialogType == 0 && buttonId == "homepage-dialog-select-image"});
                media_uploader.on("select", function(event) {
                    var selection = media_uploader.state().get("selection");
                    if (dialogType == 0 && buttonId == "homepage-dialog-select-image" && selection.length > 1) {
                        var items = [];
                        selection.map(function(attachment) {
                            attachment = attachment.toJSON();
                            if (attachment.type != "image")
                                return;
                            var thumbnail;
                            if (attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url)
                                thumbnail = attachment.sizes.thumbnail.url;
                            else if (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url)
                                thumbnail = attachment.sizes.medium.url;
                            else
                                thumbnail = attachment.url;
                            items.push({image: attachment.url,thumbnail: thumbnail,title: attachment.title,description: attachment.description,button: "",buttoncss: "read_more_cta",buttonlink: "",buttonlinktarget: "",
                                weblink: "",linktarget: "",lightbox: false,lightboxsize: false,lightboxwidth: 960,lightboxheight: 540})
                        });
                        $slideDialog.remove();
                        onSuccess(items)
                    } else {
                        attachment = selection.first().toJSON();
                        if (buttonId == "homepage-dialog-select-image") {
                            if (attachment.type != "image") {
                                $("#homepage-dialog-error").css({display: "block"}).html("<p>Please select an image file</p>");
                                return
                            }
                            var thumbnail;
                            if (attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url)
                                thumbnail = attachment.sizes.thumbnail.url;
                            else if (attachment.sizes && 
                            attachment.sizes.medium && attachment.sizes.medium.url)
                                thumbnail = attachment.sizes.medium.url;
                            else
                                thumbnail = attachment.url;
                            $("#homepage-dialog-image-display-tr").css({display: "table-row"});
                            $("#homepage-dialog-image-display").attr("src", attachment.url);
                            $("#homepage-dialog-image").val(attachment.url);
                            $("#homepage-dialog-thumbnail").val(thumbnail);
                            if ($.trim($("#homepage-dialog-image-title").val()).length <= 0)
                                $("#homepage-dialog-image-title").val(attachment.title);
                            $("#homepage-dialog-image-description").val(attachment.description)
                        } else if (buttonId == 
                        "homepage-dialog-select-thumbnail") {
                            if (attachment.type != "image") {
                                $("#homepage-dialog-error").css({display: "block"}).html("<p>Please select an image file</p>");
                                return
                            }
                            $("#homepage-dialog-thumbnail").val(attachment.url)
                        } else {
                            if (attachment.type != "video") {
                                $("#homepage-dialog-error").css({display: "block"}).html("<p>Please select a video file</p>");
                                return
                            }
                            $("#" + textId).val(attachment.url)
                        }
                    }
                    $("#homepage-dialog-error").css({display: "none"}).empty()
                });
                media_uploader.open()
            };
            if (parseInt($("#homepage-wp-history-media-uploader").text()) == 
            1) {
                var buttonId = "";
                var textId = "";
                var history_media_upload_onclick = function(event) {
                    buttonId = $(this).attr("id");
                    textId = $(this).data("textid");
                    var mediaType = buttonId == "homepage-dialog-select-image" || buttonId == "homepage-dialog-select-thumbnail" ? "image" : "video";
                    tb_show("Upload " + mediaType, "media-upload.php?referer=homepage&type=" + mediaType + "&TB_iframe=true", false);
                    return false
                };
                window.send_to_editor = function(html) {
                    tb_remove();
                    if (buttonId == "homepage-dialog-select-image") {
                        var $img = 
                        $("img", html);
                        if (!$img.length) {
                            $("#homepage-dialog-error").css({display: "block"}).html("<p>Please select an image file</p>");
                            return
                        }
                        var thumbnail = $img.attr("src");
                        var src = $(html).is("a") ? $(html).attr("href") : thumbnail;
                        $("#homepage-dialog-image-display-tr").css({display: "table-row"});
                        $("#homepage-dialog-image-display").attr("src", thumbnail);
                        $("#homepage-dialog-image").val(src);
                        $("#homepage-dialog-thumbnail").val(thumbnail);
                        if ($.trim($("#homepage-dialog-image-title").val()).length <= 0)
                            $("#homepage-dialog-image-title").val($("img", html).attr("title"))
                    } else if (buttonId == "homepage-dialog-select-thumbnail") {
                        var $img = $("img", html);
                        if (!$img.length) {
                            $("#homepage-dialog-error").css({display: "block"}).html("<p>Please select an image file</p>");
                            return
                        }
                        var src = $(html).is("a") ? $(html).attr("href") : $img.attr("src");
                        $("#homepage-dialog-thumbnail").val(src)
                    } else {
                        if ($("img", html).length) {
                            $("#homepage-dialog-error").css({display: "block"}).html("<p>Please select a video file</p>");
                            return
                        }
                        $("#" + textId).val($(html).attr("href"))
                    }
                    $("#homepage-dialog-error").css({display: "none"}).empty()
                };
                $("#homepage-dialog-select-image").click(history_media_upload_onclick);
                $("#homepage-dialog-select-thumbnail").click(history_media_upload_onclick);
                if (dialogType == 1) {
                    $("#homepage-dialog-select-mp4").click(history_media_upload_onclick);
                    $("#homepage-dialog-select-webm").click(history_media_upload_onclick)
                }
            } else {
                $("#homepage-dialog-select-image").click(media_upload_onclick);
                $("#homepage-dialog-select-thumbnail").click(media_upload_onclick);
                if (dialogType == 1) {
                    $("#homepage-dialog-select-mp4").click(media_upload_onclick);
                    $("#homepage-dialog-select-webm").click(media_upload_onclick)
                }
            }
            $("#homepage-dialog-ok").click(function() {
                if (dialogType != 4 &&$.trim($("#homepage-dialog-image").val()).length <= 0) {
                    $("#homepage-dialog-error").css({display: "block"}).html("<p>Please select an image file</p>");
                    return
                }
                if (dialogType == 1 && $.trim($("#homepage-dialog-mp4").val()).length <= 
                0) {
                    $("#homepage-dialog-error").css({display: "block"}).html("<p>Please select a video file</p>");
                    return
                }
                var item = {image: $.trim($("#homepage-dialog-image").val()),thumbnail: $.trim($("#homepage-dialog-thumbnail").val()),video: $.trim($("#homepage-dialog-video").val()),mp4: $.trim($("#homepage-dialog-mp4").val()),webm: $.trim($("#homepage-dialog-webm").val()),title: $.trim($("#homepage-dialog-image-title").val()),description: $.trim($("#homepage-dialog-image-description").val()),
                    button: $.trim($("#homepage-dialog-image-button").val()), boxsize: $.trim($("#homepage-dialog-boxsize").val()), buttoncss: $.trim($("#homepage-dialog-image-buttoncss").val()),buttonlink: $.trim($("#homepage-dialog-image-buttonlink").val()),buttonlinktarget: $.trim($("#homepage-dialog-image-buttonlinktarget").val()),weblink: $.trim($("#homepage-dialog-weblink").val()),linktarget: $.trim($("#homepage-dialog-linktarget").val()),lightbox: $("#homepage-dialog-lightbox").is(":checked"),lightboxsize: $("#homepage-dialog-lightbox-size").is(":checked"),
                    lightboxwidth: parseInt($.trim($("#homepage-dialog-lightbox-width").val())),lightboxheight: parseInt($.trim($("#homepage-dialog-lightbox-height").val()))};
                $slideDialog.remove();
                onSuccess([item])
            });
            $("#homepage-dialog-cancel").click(function() {
                $slideDialog.remove()
            })
        };
        var onlineVideoDialog = function(dialogType, onSuccess, videoData, invokeFromSlideDialog, dataIndex) {
            var dialogTitle = ["Image", "Video", "Youtube Video", "Vimeo Video"];
            var dialogExample = ["", "", "https://www.youtube.com/watch?v=wswxQ3mhwqQ", 
                "http://vimeo.com/1084537"];
            var dialogCode = "<div class='homepage-dialog-container'>" + "<div class='homepage-dialog-bg'></div>" + "<div class='homepage-dialog'>" + "<h3 id='homepage-dialog-title'></h3>" + "<div class='error' id='homepage-dialog-error' style='display:none;'></div>" + "<table id='homepage-dialog-form'>" + "<tr>" + "<th>Enter " + dialogTitle[dialogType] + " URL</th>" + "<td><input name='homepage-dialog-video' type='text' id='homepage-dialog-video' value='' class='regular-text' />" + 
            "<p>URL Example: " + dialogExample[dialogType] + "<p>" + "</td>" + "</tr>";
            dialogCode += "</table>" + "<div id='homepage-video-dialog-loading'></div>" + "<div class='homepage-dialog-buttons'>" + "<input type='button' class='button button-primary' id='homepage-dialog-ok' value='OK' />" + "<input type='button' class='button' id='homepage-dialog-cancel' value='Cancel' />" + "</div>" + "</div>" + "</div>";
            var $videoDialog = $(dialogCode);
            $("body").append($videoDialog);
            $(".homepage-dialog").css({"margin-top": String($(document).scrollTop() + 
                60) + "px"});
            $(".homepage-dialog-bg").css({height: $(document).height() + "px"});
            if (!videoData)
                videoData = {type: dialogType};
            $("#homepage-dialog-title").html("Add " + dialogTitle[dialogType]);
            var videoDataReturn = function() {
                $videoDialog.remove();
                slideDialog(dialogType, function(items) {
                    if (items && items.length > 0) {
                        if (typeof dataIndex !== "undefined" && dataIndex >= 0)
                            homepage_config.slides.splice(dataIndex, 1);
                        items.map(function(data) {
                            var result = {type: dialogType,image: data.image,thumbnail: data.thumbnail ? 
                                data.thumbnail : data.image,video: data.video,mp4: data.mp4,webm: data.webm,title: data.title,description: data.description,button: data.button,buttoncss: data.buttoncss,buttonlink: data.buttonlink,buttonlinktarget: data.buttonlinktarget,weblink: data.weblink,linktarget: data.linktarget,lightbox: data.lightbox,lightboxsize: data.lightboxsize,lightboxwidth: data.lightboxwidth,lightboxheight: data.lightboxheight};
                            if (typeof dataIndex !== "undefined" && dataIndex >= 0)
                                homepage_config.slides.splice(dataIndex, 0, result);
                            else
                                homepage_config.slides.push(result)
                        });
                        updateMediaTable()
                    }
                }, videoData, dataIndex)
            };
            $("#homepage-dialog-ok").click(function() {
                var href = $.trim($("#homepage-dialog-video").val());
                if (href.length <= 0) {
                    $("#homepage-dialog-error").css({display: "block"}).html("<p>Please enter a " + dialogTitle[dialogType] + " URL</p>");
                    return
                }
                if (dialogType == 2) {
                    var youtubeId = "";
                    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
                    var match = href.match(regExp);
                    if (match && 
                    match[7] && match[7].length == 11)
                        youtubeId = match[7];
                    else {
                        $("#homepage-dialog-error").css({display: "block"}).html("<p>Please enter a valid Youtube URL</p>");
                        return
                    }
                    var result = "http://www.youtube.com/embed/" + youtubeId;
                    var params = getURLParams(href);
                    var first = true;
                    for (var key in params) {
                        if (first) {
                            result += "?";
                            first = false
                        } else
                            result += "&";
                        result += key + "=" + params[key]
                    }
                    videoData.video = result;
                    videoData.image = "http://img.youtube.com/vi/" + youtubeId + "/0.jpg";
                    videoData.thumbnail = "http://img.youtube.com/vi/" + youtubeId + 
                    "/1.jpg";
                    videoDataReturn()
                } else if (dialogType == 3) {
                    var vimeoId = "";
                    var regExp = /^.*(vimeo\.com\/)((video\/)|(channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
                    var match = href.match(regExp);
                    if (match && match[6])
                        vimeoId = match[6];
                    else {
                        $("#homepage-dialog-error").css({display: "block"}).html("<p>Please enter a valid Vimeo URL</p>");
                        return
                    }
                    var result = "http://player.vimeo.com/video/" + vimeoId;
                    var params = getURLParams(href);
                    var first = true;
                    for (var key in params) {
                        if (first) {
                            result += "?";
                            first = false
                        } else
                            result += 
                            "&";
                        result += key + "=" + params[key]
                    }
                    videoData.video = result;
                    $("#homepage-video-dialog-loading").css({display: "block"});
                    $.ajax({url: "http://www.vimeo.com/api/v2/video/" + vimeoId + ".json?callback=?",dataType: "json",timeout: 3E3,data: {format: "json"},success: function(data) {
                            videoData.image = data[0].thumbnail_large;
                            videoData.thumbnail = data[0].thumbnail_medium;
                            videoDataReturn()
                        },error: function() {
                            videoDataReturn()
                        }})
                }
            });
            $("#homepage-dialog-cancel").click(function() {
                $videoDialog.remove();
                if (invokeFromSlideDialog)
                    videoDataReturn()
            })
        };
        var updateMediaTable = function() {
            var mediaType = ["Image", "Video", "YouTube", "Vimeo", "Text"];
            $("#homepage-media-table").empty();
            for (var i = 0; i < homepage_config.slides.length; i++)
                $("#homepage-media-table").append("<li>" + "<div class='homepage-media-table-id'>" + (i + 1) + "</div>" + "<div class='homepage-media-table-img'>" + "<img class='homepage-media-table-image' data-order='" + i + "' src='" + homepage_config.slides[i].thumbnail + "' />" + "</div>" + "<div class='homepage-media-table-type'>" + 
                mediaType[homepage_config.slides[i].type] + "</div>" + "<div class='homepage-media-table-buttons-edit'>" + "<a class='homepage-media-table-button homepage-media-table-edit'>Edit</a>&nbsp;|&nbsp;" + "<a class='homepage-media-table-button homepage-media-table-delete'>Delete</a>" + "</div>" + "<div class='homepage-media-table-buttons-move'>" + "<a class='homepage-media-table-button homepage-media-table-moveup'>Move Up</a>&nbsp;|&nbsp;" + 
                "<a class='homepage-media-table-button homepage-media-table-movedown'>Move Down</a>" + "</div>" + "<div style='clear:both;'></div>" + "</li>");
            $(".homepage-media-table-image").draggable(homepageMediaTableMove)
        };
        $("#homepage-add-image").click(function() {
            slideDialog(0, function(items) {
                items.map(function(data) {
                    homepage_config.slides.push({type: 0,image: data.image,thumbnail: data.thumbnail ? data.thumbnail : data.image,video: data.video,mp4: data.mp4,webm: data.webm,
                        title: data.title,description: data.description,button: data.button,buttoncss: data.buttoncss, boxsize: data.boxsize,buttonlink: data.buttonlink,buttonlinktarget: data.buttonlinktarget,weblink: data.weblink,linktarget: data.linktarget,lightbox: data.lightbox,lightboxsize: data.lightboxsize,lightboxwidth: data.lightboxwidth,lightboxheight: data.lightboxheight})
                });
                updateMediaTable()
            })
        });
        $("#homepage-add-video").click(function() {
            slideDialog(1, function(items) {
                items.map(function(data) {
                    homepage_config.slides.push({type: 1,
                        image: data.image,thumbnail: data.thumbnail ? data.thumbnail : data.image,video: data.video,mp4: data.mp4,webm: data.webm,title: data.title,description: data.description,button: data.button,buttoncss: data.buttoncss, boxsize: data.boxsize, buttonlink: data.buttonlink,buttonlinktarget: data.buttonlinktarget,weblink: data.weblink,linktarget: data.linktarget,lightbox: data.lightbox,lightboxsize: data.lightboxsize,lightboxwidth: data.lightboxwidth,lightboxheight: data.lightboxheight})
                });
                updateMediaTable()
            })
        });
        $("#homepage-add-youtube").click(function() {
            onlineVideoDialog(2, 
            function(items) {
                items.map(function(data) {
                    homepage_config.slides.push({type: 2,image: data.image,thumbnail: data.thumbnail ? data.thumbnail : data.image,video: data.video,mp4: data.mp4,webm: data.webm,title: data.title,description: data.description,button: data.button,buttoncss: data.buttoncss, boxsize: data.boxsize,buttonlink: data.buttonlink,buttonlinktarget: data.buttonlinktarget,weblink: data.weblink,linktarget: data.linktarget,lightbox: data.lightbox,lightboxsize: data.lightboxsize,lightboxwidth: data.lightboxwidth,lightboxheight: data.lightboxheight})
                });
                updateMediaTable()
            })
        });
        $("#homepage-add-vimeo").click(function() {
            onlineVideoDialog(3, function(items) {
                items.map(function(data) {
                    homepage_config.slides.push({type: 2,image: data.image,thumbnail: data.thumbnail ? data.thumbnail : data.image,video: data.video,mp4: data.mp4,webm: data.webm,title: data.title,description: data.description,button: data.button,buttoncss: data.buttoncss, boxsize: data.boxsize,buttonlink: data.buttonlink,buttonlinktarget: data.buttonlinktarget,weblink: data.weblink,linktarget: data.linktarget,lightbox: data.lightbox,
                        lightboxsize: data.lightboxsize,lightboxwidth: data.lightboxwidth,lightboxheight: data.lightboxheight})
                });
                updateMediaTable()
            })
        });
        $("#homepage-add-text").click(function() {
            slideDialog(4, function(items) {
                items.map(function(data) {
                    homepage_config.slides.push({type: 4,image: data.image,thumbnail: data.thumbnail ? data.thumbnail : data.image,video: data.video,mp4: data.mp4,webm: data.webm,
                        title: data.title,description: data.description,button: data.button,buttoncss: data.buttoncss, boxsize: data.boxsize,buttonlink: data.buttonlink,buttonlinktarget: data.buttonlinktarget,weblink: data.weblink,linktarget: data.linktarget,lightbox: data.lightbox,lightboxsize: data.lightboxsize,lightboxwidth: data.lightboxwidth,lightboxheight: data.lightboxheight})
                });
                updateMediaTable()
            })
        });        
        $(document).on("click", ".homepage-media-table-edit", function() {
            var index = $(this).parent().parent().index();
            var mediaType = homepage_config.slides[index].type;
            slideDialog(mediaType, function(items) {
                if (items && items.length > 0) {
                    homepage_config.slides.splice(index, 1);
                    items.map(function(data) {
                        homepage_config.slides.splice(index, 0, {type: mediaType,
                            image: data.image,thumbnail: data.thumbnail ? data.thumbnail : data.image,video: data.video,mp4: data.mp4,webm: data.webm,title: data.title,description: data.description,button: data.button,buttoncss: data.buttoncss, boxsize: data.boxsize,buttonlink: data.buttonlink,buttonlinktarget: data.buttonlinktarget,weblink: data.weblink,linktarget: data.linktarget,lightbox: data.lightbox,lightboxsize: data.lightboxsize,lightboxwidth: data.lightboxwidth,lightboxheight: data.lightboxheight})
                    });
                    updateMediaTable()
                }
            }, homepage_config.slides[index], 
            index)
        });
        $(document).on("click", ".homepage-media-table-delete", function() {
            var $tr = $(this).parent().parent();
            var index = $tr.index();
            homepage_config.slides.splice(index, 1);
            $tr.remove();
            $("#homepage-media-table").find("li").each(function(index) {
                $(this).find(".homepage-media-table-id").text(index + 1);
                $(this).find("img").data("order", index);
                $(this).find("img").css({top: 0,left: 0})
            })
        });
        var homepageMediaTableMove = function(i, j) {
            var len = homepage_config.slides.length;
            if (j < 0)
                j = 0;
            if (j > len - 1)
                j = len - 1;
            if (i == j) {
                $("#homepage-media-table").find("li").eq(i).find("img").css({top: 0,left: 0});
                return
            }
            var $tr = $("#homepage-media-table").find("li").eq(i);
            var data = homepage_config.slides[i];
            homepage_config.slides.splice(i, 1);
            homepage_config.slides.splice(j, 0, data);
            var $trj = $("#homepage-media-table").find("li").eq(j);
            $tr.remove();
            if (j > i)
                $trj.after($tr);
            else
                $trj.before($tr);
            $("#homepage-media-table").find("li").each(function(index) {
                $(this).find(".homepage-media-table-id").text(index + 
                1);
                $(this).find("img").data("order", index);
                $(this).find("img").css({top: 0,left: 0})
            });
            $tr.find("img").draggable(homepageMediaTableMove)
        };
        $(document).on("click", ".homepage-media-table-moveup", function() {
            var $tr = $(this).parent().parent();
            var index = $tr.index();
            var data = homepage_config.slides[index];
            homepage_config.slides.splice(index, 1);
            if (index == 0) {
                homepage_config.slides.push(data);
                var $last = $tr.parent().find("li:last");
                $tr.remove();
                $last.after($tr)
            } else {
                homepage_config.slides.splice(index - 
                1, 0, data);
                var $prev = $tr.prev();
                $tr.remove();
                $prev.before($tr)
            }
            $("#homepage-media-table").find("li").each(function(index) {
                $(this).find(".homepage-media-table-id").text(index + 1);
                $(this).find("img").data("order", index);
                $(this).find("img").css({top: 0,left: 0})
            });
            $tr.find("img").draggable(homepageMediaTableMove)
        });
        $(document).on("click", ".homepage-media-table-movedown", function() {
            var $tr = $(this).parent().parent();
            var index = $tr.index();
            var len = homepage_config.slides.length;
            var data = homepage_config.slides[index];
            homepage_config.slides.splice(index, 1);
            if (index == len - 1) {
                homepage_config.slides.unshift(data);
                var $first = $tr.parent().find("li:first");
                $tr.remove();
                $first.before($tr)
            } else {
                homepage_config.slides.splice(index + 1, 0, data);
                var $next = $tr.next();
                $tr.remove();
                $next.after($tr)
            }
            $("#homepage-media-table").find("li").each(function(index) {
                $(this).find(".homepage-media-table-id").text(index + 1);
                $(this).find("img").data("order", 
                index);
                $(this).find("img").css({top: 0,left: 0})
            });
            $tr.find("img").draggable(homepageMediaTableMove)
        });
        var configSkinOptions = ["showbottomshadow", "navshowpreview", "border", "autoplay", "randomplay", "autoplayvideo", "isresponsive", "showtext", "arrowstyle", "showtimer", "loop", "slideinterval", "arrowimage", "arrowwidth", "arrowheight", "arrowtop", "arrowmargin", "navstyle", "navimage", "navwidth", "navheight", "navspacing", "navmarginx", "navmarginy", "playvideoimage", "playvideoimagewidth", "playvideoimageheight", "textformat"];
        var configTextOptions = ["textcss", "textbgcss", "titlecss", "descriptioncss", "textpositionstatic", "textpositiondynamic"];
        /*
        var defaultSkinOptions = {};
        for (var key in HOMEPAGE_SLIDER_SKIN_OPTIONS) {
            defaultSkinOptions[key] = {};
            for (var i = 0; i < configSkinOptions.length; i++)
                defaultSkinOptions[key][configSkinOptions[i]] = HOMEPAGE_SLIDER_SKIN_OPTIONS[key][configSkinOptions[i]];
            defaultSkinOptions[key]["scalemode"] = "fill";
            defaultSkinOptions[key]["arrowimagemode"] = "defined";
            defaultSkinOptions[key]["navimagemode"] = 
            "defined";
            defaultSkinOptions[key]["fullwidth"] = false;
            defaultSkinOptions[key]["paddingleft"] = 0;
            if (key == "vertical")
                defaultSkinOptions[key]["paddingright"] = 72;
            else if (key == "rightthumbs")
                defaultSkinOptions[key]["paddingright"] = 140;
            else if (key == "featurelist" || key == "righttabs" || key == "righttabsdark")
                defaultSkinOptions[key]["paddingright"] = 240;
            else if (key == "verticalnumber")
                defaultSkinOptions[key]["paddingright"] = 48;
            else
                defaultSkinOptions[key]["paddingright"] = 0;
            defaultSkinOptions[key]["paddingtop"] = 0;
            if (key == 
            "topcarousel")
                defaultSkinOptions[key]["paddingtop"] = 84;
            defaultSkinOptions[key]["paddingbottom"] = 0;
            for (var i = 0; i < configTextOptions.length; i++)
                if (defaultSkinOptions[key]["textformat"] in homepage_SLIDER_TEXT_EFFECT_FORMATS)
                    defaultSkinOptions[key][configTextOptions[i]] = homepage_SLIDER_TEXT_EFFECT_FORMATS[defaultSkinOptions[key]["textformat"]][configTextOptions[i]]
        }
        var printSkinOptions = function(options) {
            $("#homepage-showbottomshadow").attr("checked", options.showbottomshadow);
            $("#homepage-navshowpreview").attr("checked", 
            options.navshowpreview);
            $("#homepage-border").val(options.border);
            $("#homepage-paddingleft").val(options.paddingleft);
            $("#homepage-paddingright").val(options.paddingright);
            $("#homepage-paddingtop").val(options.paddingtop);
            $("#homepage-paddingbottom").val(options.paddingbottom);
            $("input:radio[name=homepage-arrowimagemode][value=" + options.arrowimagemode + "]").attr("checked", true);
            if (homepage_config.arrowimagemode == "custom") {
                $("#homepage-customarrowimage").val(options.arrowimage);
                $("#homepage-displayarrowimage").attr("src", options.arrowimage)
            } else {
                $("#homepage-arrowimage").val(options.arrowimage);
                $("#homepage-displayarrowimage").attr("src", $("#homepage-jsfolder").text() + options.arrowimage)
            }
            $("#homepage-arrowstyle").val(options.arrowstyle);
            $("#homepage-arrowwidth").val(options.arrowwidth);
            $("#homepage-arrowheight").val(options.arrowheight);
            $("#homepage-arrowtop").val(options.arrowtop);
            $("#homepage-arrowmargin").val(options.arrowmargin);
            if (options.navstyle != "bullets")
                $("#homepage-confignavimage").hide();
            else {
                $("#homepage-confignavimage").show();
                $("input:radio[name=homepage-navimagemode][value=" + options.navimagemode + "]").attr("checked", true);
                if (homepage_config.navimagemode == "custom") {
                    $("#homepage-customnavimage").val(options.navimage);
                    $("#homepage-displaynavimage").attr("src", options.navimage)
                } else {
                    $("#homepage-navimage").val(options.navimage);
                    $("#homepage-displaynavimage").attr("src", 
                    $("#homepage-jsfolder").text() + options.navimage)
                }
                $("#homepage-navwidth").val(options.navwidth);
                $("#homepage-navheight").val(options.navheight);
                $("#homepage-navspacing").val(options.navspacing);
                $("#homepage-navmarginx").val(options.navmarginx);
                $("#homepage-navmarginy").val(options.navmarginy)
            }
            $("#homepage-playvideoimage").val(options.playvideoimage);
            $("#homepage-displayplayvideoimage").attr("src", $("#homepage-jsfolder").text() + 
            options.playvideoimage);
            $("#homepage-playvideoimagewidth").val(options.playvideoimagewidth);
            $("#homepage-playvideoimageheight").val(options.playvideoimageheight);
            $("#homepage-textformat").val(options.textformat);
            $("#homepage-textcss").val(options.textcss);
            $("#homepage-textbgcss").val(options.textbgcss);
            $("#homepage-titlecss").val(options.titlecss);
            $("#homepage-descriptioncss").val(options.descriptioncss);
            $("#homepage-textpositionstatic").val(options.textpositionstatic);
            var positions = options.textpositiondynamic.split(",");
            for (var i = 0; i < DYNAMIC_POSITIONS.length; i++)
                $("#homepage-textpositiondynamic-" + DYNAMIC_POSITIONS[i]).attr("checked", positions.indexOf(DYNAMIC_POSITIONS[i]) > -1);
            if (homepage_SLIDER_TEXT_EFFECT_FORMATS[options.textformat]["textstyle"] == "static") {
                $(".homepage-texteffect-static").css({display: "block"});
                $(".homepage-texteffect-dynamic").css({display: "none"})
            } else if (homepage_SLIDER_TEXT_EFFECT_FORMATS[options.textformat]["textstyle"] == 
            "dynamic") {
                $(".homepage-texteffect-static").css({display: "none"});
                $(".homepage-texteffect-dynamic").css({display: "block"})
            }
        };
        $("input:radio[name=homepage-skin]").click(function() {
            if ($(this).val() == homepage_config.skin)
                return;
            $(".homepage-tab-skin").find("img").removeClass("selected");
            $("input:radio[name=homepage-skin]:checked").parent().find("img").addClass("selected");
            homepage_config.skin = $(this).val();
            printSkinOptions(defaultSkinOptions[$(this).val()])
        });
        */
        $(".homepage-options-menu-item").each(function(index) {
            $(this).click(function() {
                if ($(this).hasClass("homepage-options-menu-item-selected"))
                    return;
                $(".homepage-options-menu-item").removeClass("homepage-options-menu-item-selected");
                $(this).addClass("homepage-options-menu-item-selected");
                $(".homepage-options-tab").removeClass("homepage-options-tab-selected");
                $(".homepage-options-tab").eq(index).addClass("homepage-options-tab-selected")
            })
        });
        var updateSliderOptions = function() {
            homepage_config.name = $.trim($("#homepage-name").val());
            homepage_config.width = parseInt($.trim($("#homepage-width").val()));
            homepage_config.height = parseInt($.trim($("#homepage-height").val()));
            homepage_config.skin = $("input:radio[name=homepage-skin]:checked").val();
            homepage_config.autoplay = $("#homepage-autoplay").is(":checked");
            homepage_config.randomplay = $("#homepage-randomplay").is(":checked");
            homepage_config.autoplayvideo = $("#homepage-autoplayvideo").is(":checked");
            homepage_config.isresponsive = $("#homepage-isresponsive").is(":checked");
            homepage_config.scalemode = $("#homepage-scalemode").val();
            homepage_config.showtext = $("#homepage-showtext").is(":checked");
            homepage_config.arrowstyle = $("#homepage-arrowstyle").val();
            homepage_config.showtimer = $("#homepage-showtimer").is(":checked");
            homepage_config.loop = parseInt($.trim($("#homepage-loop").val()));
            if (isNaN(homepage_config.loop) || homepage_config.loop < 0)
                homepage_config.loop = 0;
            homepage_config.slideinterval = parseInt($.trim($("#homepage-slideinterval").val()));
            if (isNaN(homepage_config.slideinterval) || homepage_config.slideinterval < 0)
                homepage_config.slideinterval = 8E3;
            homepage_config.fullwidth = $("#homepage-fullwidth").is(":checked");
            homepage_config.textformat = $("#homepage-textformat").val();
            homepage_config.textcss = $.trim($("#homepage-textcss").val());
            homepage_config.textbgcss = $.trim($("#homepage-textbgcss").val());
            homepage_config.titlecss = $.trim($("#homepage-titlecss").val());
            homepage_config.descriptioncss = $.trim($("#homepage-descriptioncss").val());
            homepage_config.textpositionstatic = 
            $("#homepage-textpositionstatic").val();
            var positions = [];
            for (var i = 0; i < DYNAMIC_POSITIONS.length; i++)
                if ($("#homepage-textpositiondynamic-" + DYNAMIC_POSITIONS[i]).is(":checked"))
                    positions.push(DYNAMIC_POSITIONS[i]);
            if (positions.length == 0)
                positions.push("bottomleft");
            homepage_config.textpositiondynamic = positions.join(",");
            homepage_config.showbottomshadow = $("#homepage-showbottomshadow").is(":checked");
            homepage_config.navshowpreview = $("#homepage-navshowpreview").is(":checked");
            homepage_config.border = parseInt($.trim($("#homepage-border").val()));
            if (isNaN(homepage_config.border) || homepage_config.border < 0)
                homepage_config.border = 0;
            homepage_config.paddingleft = parseInt($.trim($("#homepage-paddingleft").val()));
            if (isNaN(homepage_config.paddingleft))
                homepage_config.paddingleft = 0;
            homepage_config.paddingright = parseInt($.trim($("#homepage-paddingright").val()));
            if (isNaN(homepage_config.paddingright))
                homepage_config.paddingright = 0;
            homepage_config.paddingtop = parseInt($.trim($("#homepage-paddingtop").val()));
            if (isNaN(homepage_config.paddingtop))
                homepage_config.paddingtop = 0;
            homepage_config.paddingbottom = parseInt($.trim($("#homepage-paddingbottom").val()));
            if (isNaN(homepage_config.paddingbottom))
                homepage_config.paddingbottom = 0;
            homepage_config.arrowimagemode = 
            $("input[name=homepage-arrowimagemode]:checked").val();
            if (homepage_config.arrowimagemode == "custom")
                homepage_config.arrowimage = $.trim($("#homepage-customarrowimage").val());
            else
                homepage_config.arrowimage = $.trim($("#homepage-arrowimage").val());
            homepage_config.arrowwidth = parseInt($.trim($("#homepage-arrowwidth").val()));
            if (isNaN(homepage_config.arrowwidth) || homepage_config.arrowwidth < 0)
                homepage_config.arrowwidth = 
                defaultSkinOptions[homepage_config.skin]["arrowwidth"];
            homepage_config.arrowheight = parseInt($.trim($("#homepage-arrowheight").val()));
            if (isNaN(homepage_config.arrowheight) || homepage_config.arrowheight < 0)
                homepage_config.arrowheight = defaultSkinOptions[homepage_config.skin]["arrowheight"];
            homepage_config.arrowtop = parseInt($.trim($("#homepage-arrowtop").val()));
            if (isNaN(homepage_config.arrowtop))
                homepage_config.arrowtop = 
                defaultSkinOptions[homepage_config.skin]["arrowtop"];
            homepage_config.arrowmargin = parseInt($.trim($("#homepage-arrowmargin").val()));
            if (isNaN(homepage_config.arrowmargin))
                homepage_config.arrowmargin = defaultSkinOptions[homepage_config.skin]["arrowmargin"];
            /*
            homepage_config.navstyle = defaultSkinOptions[homepage_config.skin]["navstyle"];
            if (homepage_config.navstyle == "bullets") {
                homepage_config.navimagemode = 
                $("input[name=homepage-navimagemode]:checked").val();
                if (homepage_config.navimagemode == "custom")
                    homepage_config.navimage = $.trim($("#homepage-customnavimage").val());
                else
                    homepage_config.navimage = $.trim($("#homepage-navimage").val());
                homepage_config.navwidth = parseInt($.trim($("#homepage-navwidth").val()));
                if (isNaN(homepage_config.navwidth) || homepage_config.navwidth < 0)
                    homepage_config.navwidth = 
                    defaultSkinOptions[homepage_config.skin]["navwidth"];
                homepage_config.navheight = parseInt($.trim($("#homepage-navheight").val()));
                if (isNaN(homepage_config.navheight) || homepage_config.navheight < 0)
                    homepage_config.navheight = defaultSkinOptions[homepage_config.skin]["navheight"];
                homepage_config.navspacing = parseInt($.trim($("#homepage-navspacing").val()));
                if (isNaN(homepage_config.navspacing))
                    homepage_config.navspacing = 
                    defaultSkinOptions[homepage_config.skin]["navspacing"];
                homepage_config.navmarginx = parseInt($.trim($("#homepage-navmarginx").val()));
                if (isNaN(homepage_config.navmarginx))
                    homepage_config.navmarginx = defaultSkinOptions[homepage_config.skin]["navmarginx"];
                homepage_config.navmarginy = parseInt($.trim($("#homepage-navmarginy").val()));
                if (isNaN(homepage_config.navmarginy))
                    homepage_config.navmarginy = 
                    defaultSkinOptions[homepage_config.skin]["navmarginy"]
            } else {
                homepage_config.navimage = defaultSkinOptions[homepage_config.skin]["navimage"];
                homepage_config.navwidth = defaultSkinOptions[homepage_config.skin]["navwidth"];
                homepage_config.navheight = defaultSkinOptions[homepage_config.skin]["navheight"];
                homepage_config.navspacing = defaultSkinOptions[homepage_config.skin]["navspacing"];
                homepage_config.navmarginx = 
                defaultSkinOptions[homepage_config.skin]["navmarginx"];
                homepage_config.navmarginy = defaultSkinOptions[homepage_config.skin]["navmarginy"]
            }
            */
            homepage_config.playvideoimage = $.trim($("#homepage-playvideoimage").val());
            homepage_config.playvideoimagewidth = parseInt($.trim($("#homepage-playvideoimagewidth").val()));
            if (isNaN(homepage_config.playvideoimagewidth) || homepage_config.playvideoimagewidth < 0)
                homepage_config.playvideoimagewidth = 
                defaultSkinOptions[homepage_config.skin]["playvideoimagewidth"];
            homepage_config.playvideoimageheight = parseInt($.trim($("#homepage-playvideoimageheight").val()));
            if (isNaN(homepage_config.playvideoimageheight) || homepage_config.playvideoimageheight < 0)
                homepage_config.playvideoimageheight = defaultSkinOptions[homepage_config.skin]["playvideoimageheight"];
            var transition = [];
            for (var i = 0; i < TRANSITION_EFFECTS.length; i++)
                if ($("#homepage-effect-" + 
                TRANSITION_EFFECTS[i]).is(":checked"))
                    transition.push(TRANSITION_EFFECTS[i]);
            if (transition.length == 0)
                transition.push("slice");
            homepage_config.transition = transition.join(",");
            homepage_config.lightboxresponsive = $("#homepage-lightboxresponsive").is(":checked");
            homepage_config.lightboxshownavigation = $("#homepage-lightboxshownavigation").is(":checked");
            homepage_config.lightboxshowtitle = $("#homepage-lightboxshowtitle").is(":checked");
            homepage_config.lightboxshowdescription = $("#homepage-lightboxshowdescription").is(":checked");
            homepage_config.lightboxthumbwidth = parseInt($.trim($("#homepage-lightboxthumbwidth").val()));
            homepage_config.lightboxthumbheight = parseInt($.trim($("#homepage-lightboxthumbheight").val()));
            homepage_config.lightboxthumbtopmargin = parseInt($.trim($("#homepage-lightboxthumbtopmargin").val()));
            homepage_config.lightboxthumbbottommargin = 
            parseInt($.trim($("#homepage-lightboxthumbbottommargin").val()));
            homepage_config.lightboxbarheight = parseInt($.trim($("#homepage-lightboxbarheight").val()));
            homepage_config.lightboxtitlebottomcss = $.trim($("#homepage-lightboxtitlebottomcss").val());
            homepage_config.lightboxdescriptionbottomcss = $.trim($("#homepage-lightboxdescriptionbottomcss").val());
            homepage_config.customcss = $.trim($("#homepage-custom-css").val());
            homepage_config.dataoptions = $.trim($("#homepage-data-options").val())
        };
        
        $("#homepage-textformat").change(function() {
            var textformat = $(this).val();
            if (textformat in HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS) {
                $("#homepage-textcss").val(HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[textformat]["textcss"]);
                $("#homepage-textbgcss").val(HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[textformat]["textbgcss"]);
                $("#homepage-titlecss").val(HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[textformat]["titlecss"]);
                $("#homepage-descriptioncss").val(HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[textformat]["descriptioncss"]);
                $("#homepage-textpositionstatic").val(HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[textformat]["textpositionstatic"]);
                var positions = HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[textformat]["textpositiondynamic"].split(",");
                for (var i = 0; i < DYNAMIC_POSITIONS.length; i++)
                    $("#homepage-textpositiondynamic-" + DYNAMIC_POSITIONS[i]).attr("checked", positions.indexOf(DYNAMIC_POSITIONS[i]) > 
                    -1);
                if (HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[textformat]["textstyle"] == "static") {
                    $(".homepage-texteffect-static").css({display: "block"});
                    $(".homepage-texteffect-dynamic").css({display: "none"})
                } else if (HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[textformat]["textstyle"] == "dynamic") {
                    $(".homepage-texteffect-static").css({display: "none"});
                    $(".homepage-texteffect-dynamic").css({display: "block"})
                }
            }
        });
        var escapeHTMLString = function(str) {
            return str.replace(/'/g, "&#39;").replace(/"/g, 
            "&quot;")
        };
        var previewSlider = function() {
            updateSliderOptions();
            $("#homepage-preview-container").empty();
            if (homepage_config.fullwidth)
                $("#homepage-preview-container").css({"max-width": "100%"});
            else if (homepage_config.isresponsive)
                $("#homepage-preview-container").css({"max-width": homepage_config.width + "px"});
            $("#homepage-preview-container").css({"padding-left": homepage_config.paddingleft + "px","padding-right": homepage_config.paddingright + 
                "px","padding-top": homepage_config.paddingtop + "px","padding-bottom": homepage_config.paddingbottom + "px"});
            var previewCode = "<div id='homepage-preview'";
            if (homepage_config.dataoptions && homepage_config.dataoptions.length > 0)
                previewCode += " " + homepage_config.dataoptions;
            previewCode += "></div>";
            $("#homepage-preview-container").html(previewCode);
            if (homepage_config.slides.length > 0) {
                var sliderid = homepage_config.id > 
                0 ? homepage_config.id : 0;
                $("head").find("style").each(function() {
                    if ($(this).data("creator") == "homepageslidercreator" + sliderid)
                        $(this).remove()
                });
                $("head").find("link").each(function() {
                    if ($(this).data("creator") == "homepageslidercreator" + sliderid)
                        $(this).remove()
                });
                if (homepage_config.customcss && homepage_config.customcss.length > 0)
                    $("head").append("<style type='text/css' data-creator='homepageslidercreator" + sliderid + "'>" + homepage_config.customcss + 
                    "</style>");
                var i;
                var code = '<ul class="amazingslider-slides" style="display:none;">';
                for (i = 0; i < homepage_config.slides.length; i++) {
                    code += "<li>";
                    if (homepage_config.slides[i].lightbox) {
                        code += '<a href="';
                        if (homepage_config.slides[i].type == 0)
                            code += homepage_config.slides[i].image;
                        else if (homepage_config.slides[i].type == 1) {
                            code += homepage_config.slides[i].mp4;
                            if (homepage_config.slides[i].webm)
                                code += '" data-webm="' + homepage_config.slides[i].webm
                        } else if (homepage_config.slides[i].type == 
                        2 || homepage_config.slides[i].type == 3)
                            code += homepage_config.slides[i].video;
                        if (homepage_config.slides[i].lightboxsize)
                            code += '" data-width="' + homepage_config.slides[i].lightboxwidth + '" data-height="' + homepage_config.slides[i].lightboxheight;
                        if (homepage_config.slides[i].description && homepage_config.slides[i].description.length > 0)
                            code += '" data-description="' + escapeHTMLString(homepage_config.slides[i].description);
                        code += '" class="html5lightbox">'
                    } else if (homepage_config.slides[i].weblink && homepage_config.slides[i].weblink.length > 0) {
                        code += '<a href="' + homepage_config.slides[i].weblink + '"';
                        if (homepage_config.slides[i].linktarget && homepage_config.slides[i].linktarget.length > 0)
                            code += ' target="' + homepage_config.slides[i].linktarget + '"';
                        code += ">"
                    }
                    code += '<img src="' + homepage_config.slides[i].image + '"';
                    code += ' alt="' + escapeHTMLString(homepage_config.slides[i].title) + 
                    '"';
                    code += ' data-description="' + escapeHTMLString(homepage_config.slides[i].description) + '"';
                    code += " />";
                    if (homepage_config.slides[i].lightbox || !homepage_config.slides[i].lightbox && homepage_config.slides[i].weblink && homepage_config.slides[i].weblink.length > 0)
                        code += "</a>";
                    if (!homepage_config.slides[i].lightbox)
                        if (homepage_config.slides[i].type == 1) {
                            code += '<video preload="none" src="' + homepage_config.slides[i].mp4 + 
                            '"';
                            if (homepage_config.slides[i].webm)
                                code += ' data-webm="' + homepage_config.slides[i].webm + '"';
                            code += "></video>"
                        } else if (homepage_config.slides[i].type == 2 || homepage_config.slides[i].type == 3)
                            code += '<video preload="none" src="' + homepage_config.slides[i].video + '"></video>';
                    if (homepage_config.slides[i].button && homepage_config.slides[i].button.length > 0) {
                        if (homepage_config.slides[i].buttonlink && homepage_config.slides[i].buttonlink.length > 
                        0) {
                            code += '<a href="' + homepage_config.slides[i].buttonlink + '"';
                            if (homepage_config.slides[i].buttonlinktarget && homepage_config.slides[i].buttonlinktarget.length > 0)
                                code += ' target="' + homepage_config.slides[i].buttonlinktarget + '"';
                            code += ">"
                        }
                        code += '<button class="' + homepage_config.slides[i].buttoncss + '">' + homepage_config.slides[i].button + "</button>";
                        if (homepage_config.slides[i].buttonlink && homepage_config.slides[i].buttonlink.length > 
                        0)
                            code += "</a>"
                    }
                    code += "</li>"
                }
                code += "</ul>";
                code += '<ul class="amazingslider-thumbnails" style="display:none;">';
                for (i = 0; i < homepage_config.slides.length; i++) {
                    code += '<li><img src="' + homepage_config.slides[i].thumbnail + '"';
                    if (homepage_config.slides[i].title.length > 0)
                        code += ' alt="' + escapeHTMLString(homepage_config.slides[i].title) + '"';
                    if (homepage_config.slides[i].description.length > 0)
                        code += ' title="' + escapeHTMLString(homepage_config.slides[i].description) + 
                        '"';
                    code += " /></li>"
                }
                code += "</ul>";
                $("#homepage-preview").html(code);
                var jsfolder = $("#homepage-jsfolder").text();
                var sliderOptions = $.extend({}, HOMEPAGE_SLIDER_SKIN_OPTIONS[homepage_config["skin"]], HOMEPAGE_SLIDER_TEXT_EFFECT_FORMATS[homepage_config["textformat"]], {sliderid: sliderid,jsfolder: jsfolder}, homepage_config);
                $("#homepage-preview").homepageslider(sliderOptions)
            }
        };
        var publishSlider = function() {
            $("#homepage-publish-loading").show();
            updateSliderOptions();
            jQuery.ajax({url: ajaxurl,type: "POST",data: {action: "homepage_save_item",item: JSON.stringify(homepage_config)},success: function(data) {
                    $("#homepage-publish-loading").hide();
                    if (data.success && data.id >= 0) {
                        homepage_config.id = data.id;
                        $("#homepage-publish-information").html("<div class='updated'><p>The slider has been saved and published.</p></div>" + "<div class='updated'><p>To embed the slider into your page or post, use shortcode <b>[homepage id=\"" + 
                        data.id + '"]</b></p></div>' + "<div class='updated'><p>To embed the slider into your template, use php code <b>&lt;?php echo do_shortcode('[homepage id=\"" + data.id + "\"]'); ?&gt;</b></p></div>")
                    } else
                        $("#homepage-publish-information").html("<div class='error'><p>WordPress Ajax call failed. Please check your WordPress configuration file and make sure the WP_DEBUG is set to false.</p></div>")
                }})
        };
        var default_options = {id: -1,name: "My Slider",slides: [],transition: "slice",
            showtext: true, textformat: "Bottom bar",paddingleft: 0,paddingright: 0,
            paddingtop: 0,paddingbottom: 0,lightboxresponsive: true,lightboxshownavigation: false,
            lightboxshowtitle: true,lightboxshowdescription: false,lightboxthumbwidth: 90,
            lightboxthumbheight: 60,lightboxthumbtopmargin: 12,lightboxthumbbottommargin: 4,
            lightboxbarheight: 64,
            lightboxtitlebottomcss: "{color:#333; font-size:14px; font-family:Armata,sans-serif,Arial; overflow:hidden; text-align:left;}",
            lightboxdescriptionbottomcss: "{color:#333; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;}",
            customcss: "",dataoptions: ""};
        var homepage_config = $.extend({}, default_options);
        var sliderId = parseInt($("#homepage-id").text());
        if (sliderId >= 0) {
            var config_options = $.parseJSON($("#homepage-id-config").text());
            if ("isresponsive" in config_options && !("fullwidth" in config_options))
                config_options.fullwidth = config_options.isresponsive;
            $.extend(homepage_config, config_options);
            homepage_config.id = sliderId
        }
        var i;
        for (i = 0; i < homepage_config.slides.length; i++) {
            if (!("lightboxsize" in homepage_config.slides[i]))
                homepage_config.slides[i]["lightboxsize"] = false;
            if (!("lightboxwidth" in homepage_config.slides[i]))
                homepage_config.slides[i]["lightboxwidth"] = 960;
            if (!("lightboxheight" in homepage_config.slides[i]))
                homepage_config.slides[i]["lightboxheight"] = 540
        }
        for (i = 0; i < homepage_config.slides.length; i++) {
            homepage_config.slides[i].title = 
            homepage_config.slides[i].title.replace(/\\'/g, "'").replace(/\\"/g, '"');
            homepage_config.slides[i].description = homepage_config.slides[i].description.replace(/\\'/g, "'").replace(/\\"/g, '"')
        }
        /*
        var cssOptions = ["textcss", "textbgcss", "titlecss", "descriptioncss"];
        for (i = 0; i < cssOptions.length; i++)
            homepage_config[cssOptions[i]] = homepage_config[cssOptions[i]].replace(/\\'/g, "'").replace(/\\"/g, '"');
        */
        for (i = 0; i < homepage_config.slides.length; i++) {
            if (homepage_config.slides[i].lightbox !== 
            true && homepage_config.slides[i].lightbox !== false)
                homepage_config.slides[i].lightbox = homepage_config.slides[i].lightbox && homepage_config.slides[i].lightbox.toLowerCase() === "true";
            if (homepage_config.slides[i].lightboxsize !== true && homepage_config.slides[i].lightboxsize !== false)
                homepage_config.slides[i].lightboxsize = homepage_config.slides[i].lightboxsize && homepage_config.slides[i].lightboxsize.toLowerCase() === 
                "true"
        }
        var boolOptions = ["autoplay", "randomplay", "autoplayvideo", "isresponsive", "fullwidth", "showtext", "showtimer", "showbottomshadow", "navshowpreview", "lightboxresponsive", "lightboxshownavigation", "lightboxshowtitle", "lightboxshowdescription"];
        for (i = 0; i < boolOptions.length; i++)
            if (homepage_config[boolOptions[i]] !== true && homepage_config[boolOptions[i]] !== false)
                homepage_config[boolOptions[i]] = homepage_config[boolOptions[i]] && homepage_config[boolOptions[i]].toLowerCase() === 
                "true";
        if (homepage_config.dataoptions && homepage_config.dataoptions.length > 0)
            homepage_config.dataoptions = homepage_config.dataoptions.replace(/\\"/g, '"').replace(/\\'/g, "'");
        var printConfig = function() {
            $("#homepage-name").val(homepage_config.name);
            $("#homepage-width").val(homepage_config.width);
            $("#homepage-height").val(homepage_config.height);
            updateMediaTable();
            $(".homepage-tab-skin").find("img").removeClass("selected");
            $("input:radio[name=homepage-skin][value=" + homepage_config.skin + "]").attr("checked", true);
            $("input:radio[name=homepage-skin][value=" + homepage_config.skin + "]").parent().find("img").addClass("selected");
            $("#homepage-autoplay").attr("checked", homepage_config.autoplay);
            $("#homepage-randomplay").attr("checked", homepage_config.randomplay);
            $("#homepage-autoplayvideo").attr("checked", homepage_config.autoplayvideo);
            $("#homepage-isresponsive").attr("checked", homepage_config.isresponsive);
            $("#homepage-scalemode").val(homepage_config.scalemode);
            $("#homepage-showtext").attr("checked", homepage_config.showtext);
            $("#homepage-showtimer").attr("checked", homepage_config.showtimer);
            $("#homepage-loop").val(homepage_config.loop);
            $("#homepage-slideinterval").val(homepage_config.slideinterval);
            $("#homepage-fullwidth").attr("checked", homepage_config.fullwidth);
            var transition = homepage_config.transition.split(",");
            for (var i = 0; i < TRANSITION_EFFECTS.length; i++)
                $("#homepage-effect-" + TRANSITION_EFFECTS[i]).attr("checked", transition.indexOf(TRANSITION_EFFECTS[i]) > -1);
            $("#homepage-lightboxresponsive").attr("checked", homepage_config.lightboxresponsive);
            $("#homepage-lightboxshownavigation").attr("checked", homepage_config.lightboxshownavigation);
            $("#homepage-lightboxshowtitle").attr("checked", homepage_config.lightboxshowtitle);
            $("#homepage-lightboxshowdescription").attr("checked", homepage_config.lightboxshowdescription);
            $("#homepage-lightboxthumbwidth").val(homepage_config.lightboxthumbwidth);
            $("#homepage-lightboxthumbheight").val(homepage_config.lightboxthumbheight);
            $("#homepage-lightboxthumbtopmargin").val(homepage_config.lightboxthumbtopmargin);
            $("#homepage-lightboxthumbbottommargin").val(homepage_config.lightboxthumbbottommargin);
            $("#homepage-lightboxbarheight").val(homepage_config.lightboxbarheight);
            $("#homepage-lightboxtitlebottomcss").val(homepage_config.lightboxtitlebottomcss);
            $("#homepage-lightboxdescriptionbottomcss").val(homepage_config.lightboxdescriptionbottomcss);
            //printSkinOptions(homepage_config);
            $("#homepage-custom-css").val(homepage_config.customcss);
            $("#homepage-data-options").val(homepage_config.dataoptions)
        };
        printConfig()
    });
    $.fn.draggable = function(callback) {
        this.css("cursor", "move").on("mousedown", function(e) {
            var $dragged = $(this);
            var x = $dragged.offset().left - e.pageX;
            var y = $dragged.offset().top - e.pageY;
            var z = $dragged.css("z-index");
            $(document).on("mousemove.draggable", function(e) {
                $dragged.css({"z-index": 999}).offset({left: x + e.pageX,top: y + e.pageY});
                e.preventDefault()
            }).one("mouseup", function() {
                $(this).off("mousemove.draggable click.draggable");
                $dragged.css("z-index", z);
                var i = $dragged.data("order");
                var coltotal = Math.floor($dragged.parent().parent().parent().innerWidth() / $dragged.parent().parent().outerWidth());
                var row = Math.floor(($dragged.offset().top - $dragged.parent().parent().parent().offset().top) / $dragged.parent().parent().outerHeight());
                var col = Math.floor(($dragged.offset().left - $dragged.parent().parent().parent().offset().left) / $dragged.parent().parent().outerWidth());
                var j = row * coltotal + col;
                callback(i, j)
            });
            e.preventDefault()
        });
        return this
    }
})(jQuery);
