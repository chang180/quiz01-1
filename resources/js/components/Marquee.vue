<template>
    <div class="relative w-100 h-8 overflow-hidden" ref="marquee">
        <div class="absolute w-max" ref="content">
            <slot></slot>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        let marquee = this.$refs.marquee.offsetWidth
        let content = this.$refs.content.offsetWidth
            // console.log(marquee, content)
        this.$refs.content.style.right = (0 - content) + "px"
        let pos = 0 - content
        setInterval(() => {
            pos++
            this.$refs.content.style.right = pos + "px"
            if (pos >= marquee) pos = 0 - content
        }, 15);
    }
}
</script>
