<template>
 <div class="alert alert-success" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>

export default {
    props: ['message'],
    data() {
        return {
            body : '',
            show: false
        }
    },
    created(){
       if (this.message) {
            this.flash(this.message);
        }

        window.events.$on('flash', message => {
            this.flash(message);
        })
    },
    methods : {
          flash(message) {
                this.body = message;
                this.show = true;
                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 4000);
            }
    }
}
</script>

<style scoped>
.alert-success {
    position: fixed;
    right: 25px;
    bottom: 25px;
}
</style>
