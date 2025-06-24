<script setup>
    import Header from './Header.vue';
    import { reactive, ref } from 'vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({userLogin: String});

    const userLogin = props.userLogin;
    const title = ref('Новый опрос');
    const category = ref('Технологии');

    const optionsList = reactive([
        {
            'id': 1,
            'text': 'Вариант ответа'
        },
    ]);

    function addOption() {
        optionsList.push({
            id: optionsList[optionsList.length - 1].id + 1,
            text: 'Вариант ответа'
        });
    }

    function deleteOption(optionId) {
        optionsList.splice(optionsList.indexOf(optionsList.find(option => option.id == optionId)), 1);
    }

    function createPoll() {
        router.post('/polls/add', {
            'options': optionsList,
            'title': title.value,
            'category': category.value
        }).catch(error => {
            console.log('error');
        });
    }
</script>

<template>
    <title>Создание опроса</title>
    <Header>
        <li class="leading-none"><a @click="router.get('/')" class="cursor-pointer hover:underline">Главная</a></li>
        <li class="leading-none"><a @click="router.get('/polls')" class="cursor-pointer hover:underline">Все опросы</a></li>
        <li class="leading-none"><a @click="router.get('/polls/user')" class="cursor-pointer hover:underline">Мои опросы</a></li>
    </Header>
    <p class="text-white text-center mt-[5%] text-3xl p-0">
        Создание опроса
    </p>
        <div class="text-white flex flex-col p-[20px_30px] bg-[#057DCD] rounded-[20px] w-[500px] justify-between mx-auto mt-[5%]">
            <textarea v-model="title" class="bg-transparent border-none w-full mt-5 mb-10 text-center
            text-[23px] text-white font-Comfortaa resize-none overflow-hidden" maxlength="40">
                Новый опрос
            </textarea>
            <ul class="flex flex-col list-none m-0 w-[445px]">
                <li class="flex flex-col h-auto text-[17px] mb-[50px]">
                    <p v-for="option in optionsList" :key="option.id" class="flex h-fit gap-[10px] w-[390px]">
                        <input type="radio" class="w-5 h-5" />
                        <textarea v-model="option.text" class="resize-none overflow-hidden w-full bg-transparent
                        text-white font-Comfortaa border-none text-[17px] mb-5" maxlength="30">
                            {{ option.text }}
                        </textarea>
                        <button v-if="option.id != 1" @click="deleteOption(option.id)" class="h-fit w-fit bg-transparent
                        text-powderblue border-none font-Comfortaa text-[17px] cursor-pointer">
                            Удалить
                        </button>
                    </p>
                   <button @click="addOption" id="addOption" class="bg-transparent text-white font-Comfortaa border-none
                   w-[390px] text-[17px] text-left cursor-pointer">
                        + Добавить вариант ответа
                    </button>
                </li>
            </ul>
            <div class="flex justify-between">
                <a id="poll-author" class="m-0 text-white">
                    {{ userLogin }}
                </a>
                <select v-model="category" class="bg-[#057DCD] text-white">
                    <option>Технологии</option>
                    <option>Игры</option>
                    <option>Кино и сериалы</option>
                </select>
                <p class="mb-0">Активен</p>
            </div>
        </div>
    <button @click="createPoll" class="border-none py-[15px] text-xl w-fit h-fit text-[#057DCD] rounded-[10px] bg-white
        block cursor-pointer p-3 px-[3%] mx-auto my-[5%]">
        Создать
    </button>
</template>
