<template>
    <div>
        <output :id="outputId" class="upload"></output>
        <input :id="uploadId" type="file" multiple v-on:change="filesAppended"></input>
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
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb upload" src="', e.target.result,
                                    '" title="', escape(theFile.name), '"/>'].join('');

                    document.getElementById(vm.outputId).insertBefore(span, null);
                    };
                })(file);

                // Read in the image file as a data URL.
                reader.readAsDataURL(file);
            },
            renderThumbError : function() {
                var span = document.createElement('span');
                span.className = "thumb-error thumb upload";
                span.innerHTML = '<span class="glyphicon glyphicon-remove"></span>'

                document.getElementById(this.outputId).insertBefore(span, null);
            }
        }
    }
</script>
