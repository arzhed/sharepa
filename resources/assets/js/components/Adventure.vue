<template>
    <div class="adventure-item-container col-lg-3 col-md-4">
        <router-link class="nostyle" :to="to" v-bind:model='model'>
            <div class="adventure-item">
                <div class="adventure-item-img">
                    <div class="cover">
                        <img v-if="model.cover !== undefined" :src="src ">
                    </div>
                    <div class="body">
                        <h3>{{model.title}}</h3>
                        <p>{{model.description}}</p>
                        <div class="more"> + see more </div>
                    </div>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>
    module.exports = {
        props : ['model', 'user'],
        computed : {
            src : function() {
                if (this.model.cover !== undefined)
                    return '/storage/' + this.model.cover.path;
                return '';
            },
            to : function() {
                if (this.user != undefined && this.user.role == 'traveler') {
                    return '/traveler/adventure/' + this.model.id;
                }
                return '/guide/adventure/' + this.model.id;
            }
        }
    }
</script>
