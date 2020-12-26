<template>
  <div class="text-center py-2 border-bottom my-1">主選單區</div>
  <ul class="list-group h-5/6">
    <li
      class="list-group-item list-group-action py-1 bg-warning menu"
      v-for="menu of menus"
      @mouseover="menu.show = true"
      @mouseleave="menu.show = false"
      :key="menu.id"
    >
      <router-link :to="menu.href"> {{ menu.text }} </router-link>
      <ul
        class="list-group subs offset-4 w-100"
        v-if="menu.subs.length > 0"
        v-show="menu.show"
      >
        <li
          class="list-group-item list-group-action py-1 bg-success"
          v-for="sub of menu.subs"
          :key="sub.id"
        >
          <router-link class="text-white" :to="sub.href">{{ sub.text }} </router-link>
        </li>
      </ul>
    </li>
  </ul>

  <div class="viewer text-center">進站總人數：{{ total }}</div>
</template>
<script>
export default {
props:['menus','total'],

};
</script>