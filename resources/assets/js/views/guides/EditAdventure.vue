<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a new adventure</div>
                    <div class="panel-body">
                        <form class="form-horizontal" v-on:submit="submit">
                            <div class="form-group">
                                <label for="title" class="col-md-4 control-label">Title</label>
                                <div class="col-md-6">
                                    <input type="text" v-on:input="$v.title.$touch" id="title" v-model.trim="title" class="form-control" name="title" autofocus="" placeholder=""></input>
                                    <span class="form-error" v-show="$v.title.$dirty && !$v.title.required">Title is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="photos" class="col-md-4 control-label">Photos</label>
                                <div class="col-md-6">
                                    <upload upload-id="photos" upload-url="/api/upload"></upload>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-md-4 control-label">Price</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="number" min="1" v-on:input="$v.price.$touch" id="price" v-model.trim="price" class="form-control" name="price"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="short_description" class="col-md-4 control-label">Short Description</label>
                                <div class="col-md-6">
                                    <textarea v-on:input="$v.short_description.$touch" id="short_description" v-model.trim="short_description" class="form-control" name="short_description" placeholder=""></textarea>
                                    <span class="form-error" v-show="$v.short_description.$dirty && !$v.short_description.required">Short Description is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="long_description" class="col-md-4 control-label">In details</label>
                                <div class="col-md-6">
                                    <textarea v-on:input="$v.long_description.$touch" id="long_description" v-model.trim="long_description" class="form-control" name="long_description" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" v-on:click="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

module.exports = {
    data : function() {
        return {
            title : '',
            price : 1,
            short_description : '',
            long_description : '',
            photos: {}
        }
    },
    validations : {
        title: {
            required: Validator.required
        },
        short_description: {
            required: Validator.required
        },
        long_description: {
            required: Validator.required
        },
        price : {}
    },
    methods : {
        submit : function(e) {
            e.preventDefault();
            var vm = this;
            axios.post('/api/adventure', {
                'title'             : vm.title,
                'price'             : vm.price,
                'short_description' : vm.short_description,
                'long_description'  : vm.long_description,
            }).then(function(response) {
                vm.$router.push({path: '/guide/adventures'});
            }).catch(function(error) {
            })
        }
    }
}
</script>
