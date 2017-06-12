<template>
    <div>
        <output :id="outputId" class="upload"></output>
        <input :id="uploadId" type="file" multiple v-on:change="filesAppended"></input>
    </div>
</template>

<script>
    module.exports = {
        mounted : function() {
            console.log('upid', this.uploadId)
        },
        props: ['uploadId', 'uploadUrl'],
        data : function() {
            return {
                files : {
                    last : -1
                }
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
                    this.files[++this.files.last] = f;
                    // Only process image files.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    this.upload(f);
                }
            },
            upload : function(file) {
                var vm = this;
                let data = new FormData();
                data.append('file', file);

                axios.post(this.uploadUrl, data).then(function (response) {
                    vm.renderThumbs(file);
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
