<template>
    <div v-if="open" @click.self="toggleModal" class="animated fadeIn fixed z-50 pin overflow-auto bg-smoke-dark flex">
        <div class="animated fadeInUp fixed shadow-inner max-w-md md:relative pin-b pin-x align-top m-auto justify-end md:justify-center p-8 bg-white md:rounded w-full md:h-auto md:shadow flex flex-col">
            <h2 class="text-4xl text-center font-hairline md:leading-loose text-grey md:mt-8 mb-4">{{ title }}</h2>
            <p class="text-xl leading-normal mb-8 text-center">
                {{ message }}
            </p>

            <div class="inline-flex justify-center" slot="buttons"></div>
            
            <span @click="toggleModal" class="absolute pin-t pin-r pt-4 px-4">
                <i class="fa fa-close"></i>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Modal',

    props: {
        title: {
            required: false,
            default: '',
        },

        message: {
            required: true
        }
    },

    data() {
        return {
            open: false,
        }
    },

    methods: {
        toggleModal() {
            this.open = !this.open;
        }
    }
}
</script>

