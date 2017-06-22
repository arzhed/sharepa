<template>
    <div>
        <div id="path" class="row center back-img-full">
            <div class="title text-black bold">
                Choose your path
            </div>
            <div class="col-md-6 col-md-offset-3">
                <input type="text" class="form-control" placeholder="Try"></input>
            </div>
        </div>
        <div id="experiences" class="home-adventures row text-center" v-if="!logged || user.role == 'traveler'">
            <h2>Best experiences</h2>
            <div class="col-lg-8 col-lg-offset-2 col-xs-10 col-xs-offset-1">
                <div class="row">
                    <adventure v-for="adventure in adventures" :key="adventure.id" v-bind:model="adventure"></adventure>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
module.exports = {
    mounted : function() {
        var vm = this;
        axios.get('/api/adventure').then(function(r) {
            vm.adventures = r.data;
        });
    },
    props : ['user', 'logged'],
    data : function() {
        return {
            adventures : []
        }
    }
}
</script>
