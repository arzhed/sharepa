<template>
    <div>
        <div class="row padding-top-45">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Who are you?</div>
                    <div class="panel-body">
                        <form class="form-horizontal" v-on:submit="submit">
                            <div class="form-group">
                                <label for="photos" class="col-md-4 control-label">Photo</label>
                                <div class="col-md-6">
                                    <!-- <upload upload-id="photos" upload-url="/api/upload" img-prefix="/storage" :file-ids="photo_ids" v-on:update:file-ids="updateFiles" single="true"></upload> -->
                                    <upload upload-id="photos" cover="true" upload-url="/api/upload" img-prefix="/storage" :file-ids="photo_ids" single="true" v-on:update:file-ids="updateFiles"></upload>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="short_bio" class="col-md-4 control-label">Catchphrase</label>

                                <div class="col-md-6">
                                    <textarea v-on:input="$v.short_bio.$touch" id="short_bio" v-model.trim="short_bio" class="form-control" name="short_bio" autofocus="" placeholder="What are your values? (300 characters max)" maxlength="300"></textarea>
                                    <span class="form-error" v-show="$v.short_bio.$dirty && !$v.short_bio.required">Short biography is required</span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="long_bio" class="col-md-4 control-label">Background</label>

                                <div class="col-md-6">
                                    <textarea v-on:input="$v.long_bio.$touch" id="long_bio" v-model.trim="long_bio" class="form-control" name="long_bio" placeholder="Tell us more about yourself"></textarea>
                                    <span class="form-error" v-show="$v.long_bio.$dirty && !$v.long_bio.required">Long biography is required</span>
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
        data : function () {
            return {
                short_bio     : '',
                long_bio      : '',
                callbackError : false,
                photo_ids : []
            }
        },
        validations : {
            short_bio: {
                required: Validator.required
            },
            long_bio: {
                required: Validator.required
            },
        },
        methods : {
            updateFiles: function(val) {
                console.log('uppdatete')
                this.photo_ids = val;
            },
            submit: function(e) {
                e.preventDefault();
                this.callbackError = false;
                var vm = this;

                axios.put('/api/user/' + this.$parent.user.id, {
                    short_bio: this.short_bio,
                    long_bio : this.long_bio,
                    photo    : this.photo_ids.length == 0 ? null : this.photo_ids[0]
                }).then(function(response) {
                    vm.$router.push({path: '/'});
                }).catch(function(error) {
                })
            },
        }
    }
</script>
