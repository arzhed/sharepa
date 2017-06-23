<template>
    <div id="adventure-read">
        <div id="cover-container" class="row ">
            <img :src="'/storage/' + model.cover.path"/>
        </div>
        <div class="row">
            <img v-for="file in model.files" v-if="file.id != model.cover_photo" :src="'/storage/' + file.path" class="thumb-img"/>
        </div>
        <div id="adventure-body" class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2>{{model.title}}</h2>
                <div id="adventure-body-header" class="row panel panel-default ">
                    <div id="guide-sider" class="col-md-3">
                        <div class="row">
                            <img src="/img/user.png"/>
                        </div>
                        {{model.guide.name}}
                    </div>
                    <div class="col-md-9">
                        <div id="short_description" class="panel-body">
                            {{model.description}}
                        </div>
                    </div>
                </div>
                <div class="row panel panel-default">
                    <div id="long_description" class="panel-body col-md-10 col-md-offset-1">
                        {{model.long_description}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

module.exports = {
    created : function() {
        //if we are EDITING an existing adventure, NOT CREATING
        if (this.$route.params.id != undefined) {
            var vm = this;
            axios.get('/api/adventure/' + this.$route.params.id).then(function(response) {
                console.log('res', response)
                vm.model = response.data;
            });
        }
    },
    data : function() {
        return {
            model : {
                title : '',
                price : 1,
                description : '',
                long_description : '',
                files : [],
                cover_photo : null
            }
        }
    },
    validations : {
        model : {
            title: {
                required: Validator.required
            },
            description: {
                required: Validator.required
            },
            long_description: {
                required: Validator.required
            },
            price : {}
        }
    },
    methods : {
    }
}
</script>
