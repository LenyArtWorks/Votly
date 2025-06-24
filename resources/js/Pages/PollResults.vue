<script setup>
    import Header from './Header.vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        'poll': {
            'required': true
        },
        'category': {
            'type': String
        }
    });


</script>

<template>
    <title>Результаты опроса</title>
    <Header>
        <li><a @click="router.get('/')" class="cursor-pointer hover:underline">Главная</a></li>
        <li><a @click="router.get('/polls')" class="cursor-pointer hover:underline">Все опросы</a></li>
        <li><a @click="router.get('/polls/create')" class="cursor-pointer hover:underline">Создать опрос</a></li>
        <li><a @click="router.get('/polls/user')" class="cursor-pointer hover:underline">Мои опросы</a></li>
    </Header>
    <p class="text-[30px] text-center mt-[60px] text-white mb-[80px]">
        Результаты опроса
    </p>
    <div class="flex justify-between flex-wrap bg-white rounded-t-[30px] h-fit pt-[60px] px-[5%]
        mt-31 w-[100%] pb-[3.3%] mb-[0]">
        <ul class="list-none flex flex-col max-[1390px]:w-[60%] w-[50%] text-[#43B0F1] max-[1060px]:w-[100%]
            max-[1060px]:justify-center">
            <p class="text-[20px] text-blue-600 mb-8 text-center">Результаты</p>
            <li v-for="option in props.poll.options" class="flex flex-col pb-[15px] text-[18px] w-[100%]">
                <div class="flex justify-between w-[100%]">
                    <a>{{ option.text }}</a>
                    <a>{{ poll.votes == 0 ? 0 : Math.round((option.votes / poll.votes * 100) * 100) / 100 }}% Голосов</a>
                </div>
                <p class="border-t-[20px] border-[#43B0F1]"
                :style="{ width: poll.votes == 0 ? '0%' : `${Math.round((option.votes / poll.votes * 100) * 100) / 100}%` }">
                </p>
            </li>
        </ul>
        <div class="border-dashed border-5 border-[#43B0F1] max-[1390px]:hidden"></div>
        <div class="border-dashed border-5 border-[#43B0F1] max-[1060px]:hidden"></div>
        <ul class="text-[#057DCD] flex flex-col gap-8 text-[18px] w-[30%] max-[1060px]:w-[100%]
            max-[1060px]:justify-center">
            <p class="text-[20px] text-blue-600 text-center">Информация</p>
            <li class="max-[1060px]:text-center">
                <p>Тема: {{ props.poll.title }}</p>
            </li>
            <li class="max-[1060px]:text-center">
                <p>Категория: {{ props.category }}</p>
            </li>
            <li class="max-[1060px]:text-center">
                <p>Количество проголосовавших: {{ props.poll.votes }}</p>
            </li>
        </ul>
    </div>
</template>
