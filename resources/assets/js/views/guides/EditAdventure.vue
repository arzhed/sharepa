<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a new adventure</div>
                    <div class="panel-body">
                        <form class="form-horizontal" v-on:submit="submit">
                            <div class="form-group">
                                <label for="title" class="col-md-3 control-label">Title</label>
                                <div class="col-md-7">
                                    <input type="text" v-on:input="$v.model.title.$touch" id="title" v-model.trim="model.title" class="form-control" name="title" autofocus="" placeholder=""></input>
                                    <span class="form-error" v-show="$v.model.title.$dirty && !$v.model.title.required">Title is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="photos" class="col-md-3 control-label">Photos</label>
                                <div class="col-md-9">
                                    <upload upload-id="photos" upload-url="/api/upload" cover="true" img-prefix="/storage" :file-ids="photo_ids" v-on:update:file-ids="updateFiles" :old-files="model.files"></upload>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-md-3 control-label">Price</label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="number" min="1" v-on:input="$v.model.price.$touch" id="price" v-model.trim="model.price" class="form-control" name="price"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-md-3 control-label">Short Description</label>
                                <div class="col-md-7">
                                    <textarea v-on:input="$v.model.description.$touch" id="description" v-model.trim="model.description" class="form-control" name="description" placeholder="150 characters max" maxlength="150"></textarea>
                                    <span class="form-error" v-show="$v.model.description.$dirty && !$v.model.description.required">Short Description is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="long_description" class="col-md-3 control-label">In details</label>
                                <div class="col-md-7">
                                    <textarea v-on:input="$v.model.long_description.$touch" id="long_description" v-model.trim="model.long_description" class="form-control" name="long_description" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-4">
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
    created : function() {
        //if we are EDITING an existing adventure, NOT CREATING
        if (this.$route.params.id != undefined) {
            var vm = this;
            axios.get('/api/adventure/' + this.$route.params.id).then(function(response) {
                for (var i = 0 ; i < response.data.files.length ; i++) {
                    var file = response.data.files[i];
                    if (response.data.cover_photo != null && response.data.files[i].id == response.data.cover_photo && i!=0) {
                        vm.photo_ids.unshift(file.id);
                        response.data.files.splice(parseInt(i), 1);
                        response.data.files.unshift(file);
                    } else {
                        vm.photo_ids.push(file.id);
                    }
                }
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
            },
            photo_ids : []
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
        updateFiles: function(val) {
            this.photo_ids = val;
        },
        submit : function(e) {
            e.preventDefault();
            var vm = this;

            var callback = function(response) {
                vm.$router.push({path: '/guide/adventures'});
            };

            var params = {
                'title'             : vm.model.title,
                'price'             : vm.model.price,
                'description'       : vm.model.description,
                'long_description'  : vm.model.long_description,
                'files'             : this.photo_ids,
                'cover_photo'       : this.photo_ids[0]
            };

            if (this.$route.params.id != undefined) {
                axios.put('/api/adventure/' + this.$route.params.id, params).then(callback);
            } else {
                axios.post('/api/adventure', params).then(callback);
            }
        }
    }
}
</script>
