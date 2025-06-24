<script setup>
    import Header from './Header.vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        polls: Object,
        user: Object,
        votes: {
            type: Object,
            required: false
        }
    });

    const votes = props.votes;

    const user = props.user;

    function vote(optionId, elId) {
        if (user.login) {
            router.post('polls/vote', {
                'optionId': optionId
            });
        }
        else {
            alert('Чтобы проголосовать необходимо войти в аккаунт!');
            const el = document.getElementById(elId);
            el.checked = false;
        }
    }
</script>

<template>
    <title>Главная</title>
    <Header>
        <li class="leading-none"><a @click="router.get('/polls')" class="cursor-pointer hover:underline">Все опросы</a></li>
        <li class="leading-none"><a @click="router.get('/polls/create')" class="cursor-pointer hover:underline">Создать опрос</a></li>
        <li class="leading-none"><a @click="router.get('/polls/user')" class="cursor-pointer hover:underline">Мои опросы</a></li>
    </Header>
    <div class="flex w-full h-[200px] justify-end py-[70px] px-[30px]">
        <form action="/polls" method="GET" class="flex items-center">
            <input type="text" name="search-text" id="search-text" placeholder="Найти опрос"
                   class="rounded-[20px] bg-white border-none py-[20px] px-[50px] mr-[30px] text-center text-[20px]
                   focus:text-[#43B0F1] focus:outline-none placeholder-[#43B0F1] font-['Comfortaa',sans-serif]">
            <input type="submit" value=">" id="search-button"
                   class="py-[20px] px-[25px] text-[20px] text-white bg-[#057DCD]
                    border-none rounded-[20px] hover:cursor-pointer w-17 h-17">
        </form>
    </div>
    <p class="mt-[60px] text-[30px] text-center text-white mb-20">Активные опросы</p>
    <ul class="flex flex-wrap justify-center mx-auto mt-[50px] w-[100%] gap-[30px] px-[3%]">
      <li v-for="poll in props.polls" :key="poll.id" class="w-[500px]">
        <div class="flex flex-wrap justify-between p-[20px_30px] bg-[#057DCD] rounded-[20px] text-white">
          <a @click="router.get('poll-result', {'pollId': poll.id})" class="w-full mt-[20px] mb-[40px] text-center
          text-[23px] text-white cursor-pointer hover:underline">
            {{ poll.title }}
          </a>
          <ul class="flex flex-col w-full mb-[50px] list-none gap-8">
            <li v-for="option in poll.options" class="flex justify-between mb-[10px]">
              <p class="flex items-center gap-[10px] w-[390px] text-[17px]">
                <input v-if="poll.status=='Завершён'" type="radio" class="w-[20px] h-[20px]" disabled />
                <input v-else-if="votes && votes.find(vote => vote['option_id'] == option.id)
                    && user['login']" type="radio" class="w-[20px] h-[20px]" :name="`option-for-poll${poll.id}`" checked />
                <input v-else @click="vote(option.id, option.id)" type="radio"
                    :id="option.id" class="w-[20px] h-[20px]" :name="`option-for-poll${poll.id}`" />
                {{ option.text }}
              </p>
            </li>
          </ul>
          <a class="text-white no-underline cursor-pointer hover:underline">
            {{ poll.author }}
          </a>
          <p class="mb-0">
            {{ poll.status }}
          </p>
        </div>
      </li>
    </ul>
    <a @click="router.get('/polls')" class="cursor-pointer py-[20px] px-[50px] border-none text-[20px] bg-[#057DCD]
    rounded-[50px] no-underline text-white block w-[350px] text-center my-[100px] mx-auto">Больше опросов</a>
    <p class="text-white text-center mt-[200px] text-[30px]">Создавай опросы и узнавай мнение мира!</p>
    <div class="text-white mt-[200px] flex flex-col gap-[150px] w-[100%]">
        <div class="flex justify-between w-[760px] h-[200px] bg-[#057DCD] p-[30px] rounded-[0_50px_50px_0]
            max-[850px]:w-[90%]">
            <div>
                <p class="text-[30px] mb-[30px] w-[100%] ">Создай опрос</p>
                <p class="ml-[50px] text-[20px]">Заполни простую форму</p>
            </div>
            <p class="bg-white text-[#057DCD] rounded-[100px] w-[120px] h-[120px] text-[60px]
                text-center p-[30px] pt-[20px] my-auto">
                1
            </p>
        </div>
        <div class="flex justify-end">
            <div class="flex justify-between w-[760px] max-[850px]:w-[90%]
                h-[200px] bg-[#057DCD] p-[30px] rounded-[50px_0_0_50px]">
                <p class="bg-white text-[#057DCD] rounded-[100px] w-[120px] h-[120px] text-[60px]
                    text-center p-[30px] pt-[20px] my-auto">
                    2
                </p>
                <div>
                    <p class="text-[30px] mb-[30px] w-[100%] text-right">Поделись ссылкой</p>
                    <p class="mr-[50px] text-[20px] text-right">В соцсетях или мессенджерах</p>
                </div>
            </div>
        </div>
        <div class="flex justify-between w-[760px] max-[850px]:w-[90%] h-[200px] bg-[#057DCD] p-[30px] rounded-[0_50px_50px_0]">
            <div>
                <p class="text-[30px] mb-[30px] w-[100%]">Следи за результатами</p>
                <p class="ml-[50px] text-[20px]">В реальном времени</p>
            </div>
            <p class="bg-white text-[#057DCD] rounded-[100px]
                w-[120px] h-[120px] text-[60px] text-center p-[30px] pt-[21px] my-auto">
                3
            </p>
        </div>
    </div>
    <a href="#" class="py-[20px] px-[50px] border-none text-[20px] bg-[#057DCD] rounded-[50px]
        no-underline text-white block w-[350px] text-center my-[100px] mx-auto">
        Попробовать сейчас
    </a>
    <div class="text-white flex justify-between mt-50 mb-80 mx-auto w-[100%] text-[70px]
        text-center flex-wrap px-[20%] max-[1202px]:gap-30 max-[1202px]:justify-center">
        <p class="border-b-[5px] border-white mix-[1203px]:mr-[5%]">10 000+<br>Опросов</p>
        <p class="border-b-[5px] border-white mix-[1203px]:ml-[5%]">500 000+<br>Голосов</p>
    </div>
    <footer class="rounded-[10px_10px_0_0] bg-white flex justify-between p-[20px] items-center">
        <p class="font-bold">© 2025 Votly</p>
        <div class="flex gap-[20px]">
            <a class="text-[#43B0F1] cursor-pointer hover:underline text-[19px]">О нас</a>
            <a class="text-[#43B0F1] cursor-pointer hover:underline text-[19px]">Контакты</a>
        </div>
        <div class="flex gap-[10px]">
            <a href="#"><img src="../../images/free-icon-facebook-5968764.png" alt="tg" class="w-10"></a>
            <a href="#"><img src="../../images/free-icon-telegram-5968804.png" alt="facebook" class="w-10"></a>
        </div>
    </footer>
</template>
