<script setup>
import { watch } from 'vue';
const props = defineProps({
  loading: { type: Boolean, default: false },
  text: { type: String, default: null },
});

watch(() => props.loading, () => {
  if(props.loading) {
    document.documentElement.style.overflow = 'hidden';
  } else {
    document.documentElement.style.overflow = 'auto';
  }
}, { immediate: true });
</script>

<template>
  <teleport to="body">
    <div class="loader-container fixed inset-0 bg-black/70 z-50 flex items-center justify-center flex-col transition-all" v-if="loading">
      <div class="loader w-[50px] h-[50px]"></div>
      <span v-if="text" class="text-white text-2xl z-50 font-extrabold">{{ text }}...</span>
      <div v-if="$slots.logo" class="mt-7">
        <slot name="logo"/>
      </div>
    </div>
  </teleport>
</template>


<style scoped>


.loader  {
  animation: rotate 1s infinite;  
}
  
.loader:before,
.loader:after {   
  border-radius: 50%;
  content: '';
  display: block;
  height: 20px;  
  width: 20px;
}
.loader:before {
  animation: ball1 1.5s infinite;  
  background-color: #4DA6A7;
  box-shadow: 30px 0 0 #f8b334;
  margin-bottom: 10px;
}
.loader:after {
  animation: ball2 1.5s infinite; 
  background-color: #fff;
  box-shadow: 30px 0 0 #97bf0d;
}
  
@keyframes rotate {
  0% { 
    -webkit-transform: rotate(0deg) scale(0.8); 
    -moz-transform: rotate(0deg) scale(0.8);
  }
  50% { 
    -webkit-transform: rotate(360deg) scale(1.2); 
    -moz-transform: rotate(360deg) scale(1.2);
  }
  100% { 
    -webkit-transform: rotate(720deg) scale(0.8); 
    -moz-transform: rotate(720deg) scale(0.8);
  }
}
  
@keyframes ball1 {
    0% {
      box-shadow: 30px 0 0 var(--color-primary);
    }
    50% {
      box-shadow: 0 0 0 var(--color-primary);
      margin-bottom: 0;
      -webkit-transform: translate(15px,15px);
      -moz-transform: translate(15px, 15px);
    }
    100% {
      box-shadow: 30px 0 0 var(--color-primary);
      margin-bottom: 10px;
    }
  }
  
@keyframes ball2 {
    0% {
      box-shadow: 30px 0 0 #000;
    }
    50% {
      box-shadow: 0 0 0 #000;
      margin-top: -20px;
      -webkit-transform: translate(15px,15px);
      -moz-transform: translate(15px, 15px);
    }
    100% {
      box-shadow: 30px 0 0 #000;
      margin-top: 0;
    }
}
</style>