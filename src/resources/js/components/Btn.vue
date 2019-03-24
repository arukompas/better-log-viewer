<template>
    <button :class="buttonClasses" @click="$emit('click')">
        <slot></slot>
    </button>
</template>

<script>
var colourClasses = {
    default:  {
        active: 'hover:bg-grey bg-grey hover:text-white text-white border-grey',
        inactive: 'hover:bg-grey bg-white text-grey-dark hover:text-white text-white border-grey'
    },
    primary: {
        active: 'hover:bg-blue bg-blue hover:text-white text-white border-blue',
        inactive: 'hover:bg-blue bg-white text-blue-dark hover:text-white text-white border-blue'
    },
    success: {
        active: 'hover:bg-green bg-green hover:text-white text-white border-green',
        inactive: 'hover:bg-green bg-white text-green-dark hover:text-white text-white border-green'
    },
    info: {
        active: 'hover:bg-blue-lighter bg-blue-light hover:text-blue text-white border-blue-light',
        inactive: 'hover:bg-blue-lighter bg-white text-blue-light hover:text-blue text-white border-blue-light',
    },
    warning: {
        active: 'hover:bg-orange bg-orange hover:text-white text-white border-orange',
        inactive: 'hover:bg-orange bg-white text-orange-dark hover:text-white text-white border-orange'
    },
    danger: {
        active: 'hover:bg-red bg-red hover:text-white text-white border-red',
        inactive: 'hover:bg-red bg-white text-red-dark hover:text-white text-white border-red'
    }
};

export default {
    name: 'Btn',

    props: {
        type: {
            required: false,
            default: 'default'
        },

        active: {
            required: false,
            default: true
        }
    },

    computed: {
        buttonClasses() {
            var baseClasses = `text-sm py-2 px-3 border hover:border-transparent rounded`;

            if (this.active) {
                baseClasses = `${baseClasses} ${colourClasses[this.type].active}`;
            } else {
                baseClasses = `${baseClasses} ${colourClasses[this.type].inactive}`;
            }

            return baseClasses;
        }
    }
}
</script>

