<template>
    <div>
        <output :id="outputId" class="upload"></output>
        <input :id="uploadId" type="file" multiple v-on:change="selectUpdate"></input>
    </div>
</template>

<script>
    module.exports = {
        mounted : function() {
            console.log('upid', this.uploadId)
        },
        props: ['uploadId'],
        computed : {
            outputId : function() {
                return this.uploadId + '-list';
            }
        },
        methods : {
            selectUpdate : function() {
                var vm = this;

                var output = document.getElementById(vm.outputId);
                output.innerHTML = '';

                var files = document.getElementById(this.uploadId).files;

                for (var i = 0, f; f = files[i]; i++) {
                  // Only process image files.
                  if (!f.type.match('image.*')) {
                    continue;
                  }

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
                  })(f);

                  // Read in the image file as a data URL.
                  reader.readAsDataURL(f);
                }
            }
        }
    }
</script>
