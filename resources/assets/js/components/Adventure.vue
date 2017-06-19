<template>
    <div class="col-lg-3 col-md-4">
        <div class="adventure-item">
            <div class="adventure-item-img">
                <div class="cover">
                    <img v-if="model.cover !== undefined" :src="src ">
                </div>
                <div class="body">
                    <h3>{{model.title}}</h3>
                    <p>{{model.description}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        mounted: function() {
            console.log('this.model', this.model)
            if (this.model.cover !== undefined) {
                axios.get('/storage/' + this.model.cover.path).then(function(r) {
                    console.log('r', r)
                });
            }
        },
        props : ['model'],
        computed : {
            src : function() {
                if (this.model.cover !== undefined)
                    return '/storage/' + this.model.cover.path;
                return '';
            }
        }
    }
</script>
