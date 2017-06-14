<template>
    <div>
        <output :id="outputId" class="upload">
        </output>
        <div class="upload thumb thumb-custom add text-primary" v-on:click="triggerBrowse"><span class="glyphicon glyphicon-plus"></span></div>
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
            }
        },
        methods : {
            triggerBrowse : function() {
                document.getElementById(this.uploadId).click();
            },
            filesAppended : function() {
                var output = document.getElementById(this.outputId);
                output.innerHTML = '';

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
                    vm.renderThumbs(file);
                    vm.files_id.push(response.data.id);

                    if (i == length - 1) {
                        vm.$emit('update:files', vm.files_id);
                    }
                }).catch(function() {
                    vm.renderThumbError();
                });
            },
            renderThumbs : function(file) {
                var vm = this;
                var reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function(theFile) {
                    return function(e) {
                        // Render thumbnail.
                        var div = document.createElement('div');
                        div.className = "upload thumb-container position-relative";
                        div.innerHTML = ['<img class="thumb thumb-file upload" src="', e.target.result,
                                        '" title="', escape(theFile.name), '"/>'].join('');
                        div.innerHTML += '<div class="upload thumb thumb-hover"><span class="rm-upload glyphicon glyphicon-remove"></span></div>';

                        document.getElementById(vm.outputId).insertBefore(div, null);

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
            }
        }
    }
</script>
