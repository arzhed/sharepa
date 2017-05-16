<template>
    <div class="form-group">
        <label for="name" class="col-md-4 control-label">Describe yourself shortly</label>

        <div class="col-md-6">
            <textarea id="short_bio" class="form-control" name="short_bio" required autofocus placeholder="400 characters max" maxlength="400"></textarea>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
