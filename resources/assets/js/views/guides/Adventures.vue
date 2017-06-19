<template>
    <div class="container">
        <div class="text-center">
            <div class="row">
                <adventure v-for="adventure in adventures" :key="adventure.id" v-bind:model="adventure"></adventure>
            </div>
            <router-link class="row" to="/guide/adventures/create">
                <button class="btn btn-default">Create a new adventure</button>
            </router-link>
        </div>
    </div>
</template>

<script>

module.exports = {
    mounted : function() {
        var vm = this;
        axios.get('/api/adventure?guide').then(function(r) {
            vm.adventures = r.data;
        });
    },
    data : function() {
        return {
            adventures : []
        }
    },
    methods : {
    }
}
</script>
