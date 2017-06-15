<template>
    <div>
        <output :id="outputId" class="upload">
            <div :id="addId" class="upload add text-primary" v-on:click="triggerBrowse"><div class="upload thumb thumb-custom text-primary"><span class="glyphicon glyphicon-plus"></span></div></div>
        </output>
        <input :id="uploadId" type="file" multiple v-on:change="filesAppended" style="display:none"></input>
    </div>
</template>

<script>


    module.exports = {
        props: ['uploadId', 'uploadUrl', 'files'],
        data : function() {
            return {
                files_id : []
            }
        },
        computed : {
            outputId : function() {
                return this.uploadId + '-list';
            },
            addId : function() {
                return this.uploadId + '-add';
            }
        },
        methods : {
            triggerBrowse : function() {
                document.getElementById(this.uploadId).click();
            },
            filesAppended : function() {

                var files = document.getElementById(this.uploadId).files;

                for (var i = 0, f; f = files[i]; i++) {
                    // Only process image files.
                    if (!f.type.match('image.*')) {
                        // continue;
                    }

                    this.upload(f, i, files.length);
                }
            },
            upload : function(file, i, length) {
                var vm = this;
                let data = new FormData();
                data.append('file', file);

                axios.post(this.uploadUrl, data).then(function (response) {
                    vm.renderThumbs(file, response.data.id);
                    vm.files_id.push(response.data.id);

                    if (i == length - 1) {
                        vm.$emit('update:files', vm.files_id);
                    }
                }).catch(function() {
                    vm.renderThumbError();
                });
            },
            renderThumbs : function(file, id) {
                var vm = this;
                var reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function(theFile) {
                    return function(e) {
                        // Render thumbnail.

                        //We define a new component to be able to compile it in vue and have access to events and context
                        var ThumbComponent = Vue.extend({
                            template : [
                                '<div id="thumb-', id, '" class="upload thumb-container position-relative">',
                                    '<img class="thumb thumb-file upload" src="', e.target.result,'" title="', escape(theFile.name), '"/>',
                                    '<div class="upload thumb thumb-hover"><span data-id="',id,'" class="rm-upload glyphicon glyphicon-remove" v-on:click="removeImg"></span></div>',
                                '</div>'
                            ].join(''),
                            methods : {
                                removeImg : function(e) {
                                    vm.removeImg(e.target.dataset.id);
                                }
                            }
                        });
                        var thumb = new ThumbComponent().$mount();

                        document.getElementById(vm.outputId).insertBefore(thumb.$el, document.getElementById(vm.addId));

                    };
                })(file);

                // Read in the image file as a data URL.
                reader.readAsDataURL(file);
            },
            renderThumbError : function() {
                var div = document.createElement('div');
                div.className = "thumb thumb-custom thumb-file thumb-error upload position-relative";
                div.innerHTML = '<span class="glyphicon glyphicon-remove"></span>'

                document.getElementById(this.outputId).insertBefore(div, null);
            },
            removeImg : function(id) {
                var thumb = document.getElementById('thumb-' + id);
                thumb.parentNode.removeChild(thumb);
                this.files_id.splice(this.files_id.indexOf(id), 1);
            }
        }
    }

</script>
