<template>
    <div>
        <div v-if="bioRequired">Both fields are required</div>
        <div class="form-group">
            <label for="short_bio" class="col-md-4 control-label">Short description</label>

            <div class="col-md-6">
                <textarea id="short_bio" v-model="short_bio" class="form-control" name="short_bio" required autofocus placeholder="400 characters max" maxlength="400"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="long_bio" class="col-md-4 control-label">Tell us more about yourself</label>

            <div class="col-md-6">
                <textarea id="long_bio" v-model="long_bio" class="form-control" name="long_bio" required placeholder="Tell your clients about your background, why you became a guide..."></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-primary" v-on:click="updateUser">
                    Register
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data : function () {
            return {
                bioRequired : 0,
                short_bio : '',
                long_bio : ''
            }
        },
        methods : {
            updateUser : function() {
                if (this.short_bio == '' || this.long_bio == '') {
                    this.bioRequired = 1;
                    return;
                }
                axios.post('/oauth/token', {
            		'grant_type': 'password',
            		'client_id': 2,
            		'client_secret': 'H1e3Dy4wM6t1MJM4wx87B6ZU8KIbAf1f4ycxfYt6',
            		'username' : 'arthur.simon@openmailbox.org',
                    'password' : 'secret',
                    'scope' : ''
                }, function() {})
            }
        }
    }
</script>
