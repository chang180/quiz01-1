<template>
  <div class="h-25">
    <div class="text-center py-2 border-bottom my-1">
      {{ title }}
      <!-- <a class="float-right" :href="news.more.href" v-if="news.more.show"
        >More...</a
      > -->
    </div>
    <ul class="list-group">
      <li
        class="list-group-item list-gorup-item-action p-1 new"
        v-for="(ns, idx) of news.data"
        @mouseover="ns.show = true"
        @mouseleave="ns.show = false"
        :key="ns.id"
      >
        {{ idx + 1 + ". " + ns.short }}
        <div
          class="border border-dark rounded-shadow text-white offset-4 w-75 bg-secondary text-5 position-absolute"
          style="z-index: 1"
          v-show="ns.show"
        >
          <pre class="text-white" v-html="ns.text"></pre>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
import { ref, onMounted } from "vue";
export default {
  props: ["route"],
  setup(props) {
    // console.log(props.news.more);
    const title = ref("最新消息");
    onMounted(() => {
      switch (props.route) {
        case "index":
          title.value = "最新消息區";
          axios.get("/api/news/index").then((res)=>{
              console.log(res)
          })
          break;
        case "news":
          title.value = "更多最新消息區";
        //   props.news.more.show = false;
          axios.get("api/news/all").then((res)=>{
              console.log(res)
          })
          break;
      }
    });
    return {
      title,
      props,
    };
  },
};
</script>