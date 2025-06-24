<script setup>
    import { router } from '@inertiajs/vue3';
    function uppearMenu() {
        const menu = document.getElementById('menu');
        const display = menu.style.display;
        menu.style.display = display == 'block' ? 'none' : 'block';
    }
</script>

<template>
    <button @click="uppearMenu" class="hidden max-[889px]:block">
        <img src="../../images/menu.png" alt="Меню" class="w-10 h-10 mt-10 ml-10">
    </button>
  <header id="menu" class="bg-white rounded-b-[30px] w-[100%] max-[889px]:hidden min-[890px]:block
    max-[889px]:w-[30%] max-[889px]:rounded-r-[30px] max-[889px]:rounded-l-[0] max-[889px]:mt-10 max-[889px]:absolute">
    <nav class="text-[#43B0F1] text-[19px] py-[10px] px-[25px] flex flex-wrap h-[70px] items-center
        justify-between leading-[50px] max-[889px]:flex-col">
      <a id="logo" @click="router.get('/')" class="flex h-[50px] items-center font-[Coiny] text-[23px] gap-[5px] max-[889px]:mb-15
        cursor-pointer">
        <img src="../../images/LogoBlue.png" alt="logo" class="w-[40px] h-[40px]">Votly
      </a>
      <div class="flex h-auto items-center flex-wrap max-[889px]:flex-col">
        <ul id="links" class="list-none flex gap-[40px] mr-[50px] flex-wrap max-[889px]:flex-col">
          <slot />
        </ul>
        <a @click="router.get('user/profile')" class="flex items-center max-[889px]:mt-15 cursor-pointer">
          <img id="user-img" src="../../images/UserBlue.png" alt="" class="w-[55px] h-[55px]">
        </a>
      </div>
    </nav>
  </header>
</template>
