<script setup>
    import { useForm } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';

    const form = useForm({
        login: null,
        password: null
    });

    const props = defineProps({
        errors: {
            require: false
        }
    });
</script>

<template>
    <title>Вход</title>
  <a @click="router.get('/')" id="logo" class="flex cursor-pointer items-center justify-center text-white p-5
  font-[Coiny] text-[23px] no-underline">
    <img src="../../images/LogoWhite.png" alt="" class="w-10 h-10 mr-1">Votly
  </a>
  <form @submit.prevent="form.post('/auth/login')" class="mt-15 mx-auto mb-2 w-fit flex flex-col gap-2 justify-center
    flex-wrap px-15 pt-5 pb-3 bg-white rounded-[20px]">
    <p class="text-center text-[#43B0F1] text-[25px] font-extrabold mb-7">Вход</p>
    <input type="text" name="login" id="login" placeholder="Логин" v-model="form.login" class="rounded-full
    border-none text-center w-[310px] py-5 font-comfortaa shadow-[2px_1px_4px_0px_rgba(0,0,0,0.3)] text-[15px] bg-[#EDF2FA]">
    <div v-if="form.errors.login" class="text-red-500 text-center">{{ form.errors.login }}</div>
    <input type="password" name="password" id="password" placeholder="Пароль" v-model="form.password"
    class="rounded-full border-none text-center w-[310px] py-5 font-comfortaa shadow-[2px_1px_4px_0px_rgba(0,0,0,0.3)]
    text-[15px] bg-[#EDF2FA]">
    <div v-if="form.errors.password" class="text-red-500 text-center">{{ form.errors.password }}</div>
    <div v-if="errors" class="text-red-500 text-center">{{ errors.message }}</div>
    <button type="submit" class="rounded-full border-none text-center w-[310px] py-5 font-comfortaa
        shadow-[2px_1px_4px_0px_rgba(0,0,0,0.3)] text-[15px] mt-3 bg-[#057DCD] text-white cursor-pointer">
      Войти
    </button>
    <div class="flex items-center justify-between mt-5">
      <hr class="w-[120px]">
      <p class="text-black text-[15px] m-0 font-light">Или</p>
      <hr class="w-[120px]">
    </div>
    <a href="" class="flex justify-center mt-2.5">
      <img src="../../images/google-icon-logo.svg" alt="" class="w-10 h-10">
    </a>
  </form>
  <p class="text-white text-center">
    Нет аккаунта?
    <a @click="router.get('/auth/register')" class="text-white bg-transparent hover:underline cursor-pointer">
      Зарегистрироваться
    </a><br>
    <a @click="router.get('/')" class="text-white bg-transparent hover:underline">
      Войти как гость
    </a>
  </p>
</template>
