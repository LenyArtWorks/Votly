<script setup>
import { ref, onBeforeMount, reactive, onMounted, useTemplateRef } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    errors: Object,
    user: Object
});

const user = props.user;

const contents = reactive({});

const categories = useTemplateRef('categories');

const selectGender = useTemplateRef('selectGender');

const uppearOldPasswordFieldButton = useTemplateRef('uppearOldPasswordFieldButton');
const oldPasswordField = useTemplateRef('oldPasswordField');
const confirmOldPasswordButton = useTemplateRef('confirmOldPasswordButton');

const confirmNewPasswordButton = useTemplateRef('confirmNewPasswordButton');
const newPasswordField = useTemplateRef('newPasswordField');

const newPasswordChangeSuccesfull = useTemplateRef('newPasswordChangeSuccesfull');

const newLogin = ref('');
const newEmail = ref('');
const newBirthDate = ref('');
const newPassword = ref('');

const oldPassword = ref('');

const newPasswordErrors = useTemplateRef('newPasswordErrors');

onMounted(() => {
    contents.value = Array.from(document.getElementById('contents').children);
});

function elAction(elId, value, action) {
    const el = document.getElementById(elId);
    const confirm = document.getElementById(`confirmNew${value[0].toUpperCase() + value.slice(1)}`);
    const currentValue = document.getElementById(`currentUser${value[0].toUpperCase() + value.slice(1)}`);
    const appearButton = document.getElementById(`appear${value[0].toUpperCase() + value.slice(1)}FieldButton`);

    if (action == 'appear') {
        el.style.display = 'inline';
        confirm.style.display = "inline";
        currentValue.style.display = 'none';
        appearButton.style.display = "none";
    }
    else if (action == 'disappear') {
        el.style.display = 'none';
        confirm.style.display = "none";
        currentValue.style.display = 'inline';
        appearButton.style.display = "inline";
    }
}

function confirmNewLogin() {
    router.post('/user/update/login', {
        'login': newLogin.value
    });

    elAction('newLoginField', 'login', 'disappear');
};

function confirmNewEmail() {
    router.post('/user/update/email', {
        'email': newEmail.value
    });

    elAction('newEmailField', 'email', 'disappear');
};

function confirmNewBirthDate() {
    router.post('/user/update/birthdate', {
        'birthdate': newBirthDate.value
    });

    elAction('newBirthDateField', 'birthDate', 'disappear');
};

function changeContent(el, contentId) {
    contents.value.forEach((el) => {
        if (el.id != contentId && el.id != '') {
            el.style.display = 'none';
        }
        else if (el.id == contentId) {
            el.style.display = 'flex';
        }
    });
    changeElement(el);
};

function changeElement(id) {
    const el = document.getElementById(id);

    Array.from(categories.value.children).forEach(el => {
        if (el.id != 'logout' && el.id != 'close') {
            el.style.borderBottom = "3px solid #43B0F1";
            el.style.paddingBottom = "1px";
            el.style.fontWeight = "medium";
            el.style.color = "#43B0F1";
        }
    });

    el.style.borderBottom = "5px solid #057DCD";
    el.style.fontWeight = "bolder";
    el.style.color = "#057DCD";
};

function changeGender(gender) {
    router.post('/user/update/gender', {
        'gender': gender
    });
    user.gender = gender;
    selectGender.value.style.display = 'none';
}

function uppearOldPasswordField() {
    uppearOldPasswordFieldButton.value.style.display = 'none';
    oldPasswordField.value.style.display = 'inline';
    confirmOldPasswordButton.value.style.display = 'inline';
}

async function confirmOldPassword() {
    response = await axios.post('/user/check-password', {
        'password': oldPassword.value
    });

    const data = response.data;

    if (data) {
        newPasswordErrors.value.textContent = data['message'];
        newPasswordErrors.value.style.display = 'inline';
    }
    else {
        confirmNewPasswordButton.value.style.display = 'inline';
        newPasswordErrors.value.style.display = 'none';
        oldPasswordField.value.style.display = 'none';
        confirmOldPasswordButton.value.style.display = 'none';
        newPasswordField.value.style.display = 'inline';
    }
}

async function confirmNewPassword() {
    const response = await axios.post('/user/change/password', {
        'password': newPassword.value
    });

    const data = response.data;

    if (data) {
        newPasswordErrors.value.textContent = data['message'];
        newPasswordErrors.value.style.display = 'inline';
    }
    else {
        uppearOldPasswordFieldButton.value.style.display = 'inline';
        newPasswordField.value.style.display = 'none';
        newPasswordErrors.value.style.display = 'none';
        confirmNewPasswordButton.value.style.display = 'none';
        newPasswordChangeSuccesfull.value.textContent = 'Пароль успешно изменён';
        newPasswordChangeSuccesfull.value.style.display = 'inline';
        setTimeout(() => {
            newPasswordChangeSuccesfull.value.style.display = 'none';
        }, 1000);
    }
}
</script>

<template>
    <title>Профиль</title>
    <div class="flex w-[100%] flex-col justify-between h-screen min-h-[780px]">
        <div class="bg-white w-[100%] h-fit
                pr-[30px] text-[#43B0F1] box-border py-6 pb-5 pt-6 rounded-b-[30px] max-[1180px]:overflow-scroll mb-30">
                    <ul id="categories" ref="categories"
                        class="list-none text-center flex justify-between h-[100%] gap-20 px-12 w-screen">
                        <li class="no-underline text-red-500 text-[25px]" id="close">
                            <a @click="router.get('/')" class="cursor-pointer">
                                X
                            </a>
                        </li>
                        <li id="Личная информация" class="text-[#057DCD] font-bolder pb-[1px] cursor-pointer border-b-5
                            border-b-[#057DCD] cursor-pointer" @click="changeContent('Личная информация', 'private-inf')">Личная информация</li>
                        <li id="Безопасность" class="border-b-3 border-b-[#43B0F1] pb-[1px] cursor-pointer"
                            @click="changeContent('Безопасность', 'sequrity')">Безопасность</li>
                        <li id="Персонализация" class="border-b-3 border-b-[#43B0F1] pb-[1px] cursor-pointer"
                            @click="changeContent('Персонализация', 'personalization')">Персонализация</li>
                        <li id="Статистика" class="border-b-3 border-b-[#43B0F1] pb-[1px] cursor-pointer"
                            @click="changeContent('Статистика', 'stats')">Статистика</li>
                        <li id="logout" class="max-[1070px]:pr-13">
                            <a @click="router.get('/auth/logout')" class="no-underline text-red-500 block hover:underline cursor-pointer">
                                Выйти
                            </a>
                        </li>
                    </ul>
            </div>
        <div id="contents" class="bg-white w-[100%] flex flex-col
            pl-[5%] pt-15 box-border text-[#43B0F1] h-fit rounded-t-[30px] pb-50">
            <ul id="private-inf" class="list-none gap-[50px] flex flex-col pr-[50px] h-[30%]">
                <li class="border-b-[3px] border-[#43B0F1] text-[16px] pb-[15px]">
                    Логин:
                    <a id="currentUserLogin" ref="currentUserLogin" v-if="errors.login" class="text-[#43B0F1]">
                        {{ user.login }}
                    </a>
                    <a id="currentUserLogin" ref="currentUserLogin" v-else class="text-[#43B0F1]">
                        {{ newLogin.trim() == '' ? user.login : newLogin }}
                    </a>
                    <input type="text" ref="newLoginField" id="newLoginField" v-model="newLogin" class="hidden border-none border-b-[2px]
                        border-[#057DCD] text-[#43B0F1] p-[3px] text-center text-[15px]" placeholder="Новый логин" autocomplete="off"
                        maxlength="13" />
                    <button id="confirmNewLogin" ref="confirmNewLoginButton" @click="confirmNewLogin"
                        class="hidden ml-[20px] bg-none underline text-[#057DCD] text-[15px] border-none font-bold cursor-pointer">
                        Подтвердить
                    </button>
                    <button id="appearLoginFieldButton" ref="appearLoginFieldButton"
                        @click="elAction('newLoginField', 'login', 'appear')"
                        class="text-[#057DCD] font-bold ml-[10px] bg-none border-none text-[15px] underline cursor-pointer">
                        Сменить логин
                    </button>
                    <a v-if="errors.login" class="text-red-500 text-[13px] ml-[50px]">
                        {{ errors.login.includes('already') ? 'такой логин уже существует' : 'поле не должно быть пустым' }}
                    </a>
                </li>
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    Email:
                    <a id="currentUserEmail" ref="currentUserEmail" v-if="errors.email" class="text-[#43B0F1]">
                        {{ user.email }}
                    </a>
                    <a id="currentUserEmail" ref="currentUserEmail" v-else class="text-[#43B0F1]">
                        {{ newEmail.trim() == '' ? user.email : newEmail }}
                    </a>
                    <input type="email" ref="newEmailField" id="newEmailField" v-model="newEmail" class="hidden border-none border-b-[2px]
        border-[#057DCD] text-[#43B0F1] p-[3px] text-center text-[15px]" placeholder="Новый email" autocomplete="off"
                        maxlength="20" />
                    <button id="confirmNewEmail" ref="confirmNewEmailButton" @click="confirmNewEmail" class="hidden ml-[20px] bg-none
        underline text-[#057DCD] text-[15px] border-none font-bold cursor-pointer">
                        Подтвердить
                    </button>
                    <button id="appearEmailFieldButton" ref="appearEmailFieldButton"
                        @click="elAction('newEmailField', 'email', 'appear')"
                        class="text-[#057DCD] font-bold ml-[10px] bg-none border-none text-[15px] underline cursor-pointer">
                        Указать другой email
                    </button>
                    <a v-if="errors.email" class="text-red-500 ml-[50px] text-[13px]">
                        {{ errors.email.includes('already') ? 'такой email уже существует' :
                            errors.email.includes('must') ? 'неверный формат' : 'поле не должно быть пустым' }}
                    </a>
                </li>
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    Дата рождения:
                    <a id="currentUserBirthDate" ref="currentUserBirthDate" v-if="errors.birthdate"
                        class="text-[#43B0F1]">
                        {{ user.birthDate }}
                    </a>
                    <a id="currentUserBirthDate" ref="currentUserBirthDate" v-else class="text-[#43B0F1]">
                        {{ newBirthDate == '' ? (user.birthdate == undefined ? 'Не указана' : user.birthdate) : newBirthDate }}
                    </a>
                    <input type="date" ref="newBirthDateField" id="newBirthDateField" v-model="newBirthDate" class="hidden border-none border-b-[2px]
        border-[#057DCD] text-[#43B0F1] p-[3px] text-center text-[15px]" />
                    <button id="confirmNewBirthDate" ref="confirmNewBirthDateButton" @click="confirmNewBirthDate"
                        class="hidden ml-[20px] bg-none underline text-[#057DCD] text-[15px] border-none font-bold cursor-pointer">
                        Подтвердить
                    </button>
                    <button id="appearBirthDateFieldButton" ref="appearBirthDateFieldButton"
                        @click="elAction('newBirthDateField', 'birthDate', 'appear')"
                        class="text-[#057DCD] font-bold ml-[10px] bg-none border-none text-[15px] underline cursor-pointer">
                        Указать
                    </button>
                    <a v-if="errors.birthdate" class="text-red-500 ml-[50px] text-[13px]">
                        {{ errors.birthdate.includes('require') ? 'Поле не должно быть пустым' : 'Укажите реальную дату рождения' }}
                    </a>
                </li>
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    Пол:
                    <a class="cursor-pointer"
                        @click="selectGender.style.display = selectGender.style.display == 'block' ? 'none' : 'block'">
                        {{ user.gender }}&nbsp;⌵
                    </a>
                    <ul id="select-gender" ref="selectGender" class="absolute hidden ml-[60px] bg-white list-none
        w-[80px] border-[2px] border-blue-500 mt-[10px] rounded-[10px]">
                        <li @click="changeGender('муж.')" class="border-b-[2px] border-black text-center pb-[10px] pt-[10px] cursor-pointer rounded-t-[5px]
            hover:bg-blue-500 hover:text-white">
                            муж.
                        </li>
                        <li @click="changeGender('жен.')" class="text-center pt-[10px] pb-[10px] cursor-pointer rounded-b-[5px]
            hover:bg-blue-500 hover:text-white">
                            жен.
                        </li>
                    </ul>
                </li>
            </ul>
            <ul id="sequrity" class="hidden list-none flex-col gap-[50px] pr-[50px] h-[30%]">
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    <button ref="uppearOldPasswordFieldButton" @click="uppearOldPasswordField" class="text-[#057DCD] font-bold
        ml-[10px] bg-none border-none text-[15px] underline cursor-pointer">
                        Сменить пароль
                    </button>
                    <input type="password" id="oldPassword" ref="oldPasswordField" v-model="oldPassword"
                        placeholder="Введите старый пароль"
                        class="hidden border-none border-b-[2px] border-[#057DCD] text-[#43B0F1] p-[3px] text-center text-[15px]"
                        maxlength="20">
                    <button id="confirmOldPassword" ref="confirmOldPasswordButton" @click="confirmOldPassword"
                        class="hidden ml-[20px] bg-none underline text-[#057DCD] text-[15px] border-none font-bold cursor-pointer">
                        Подтвердить
                    </button>
                    <input type="password" id="newPassword" ref="newPasswordField" v-model="newPassword"
                        placeholder="Введите новый пароль"
                        class="hidden border-none border-b-[2px] border-[#057DCD] text-[#43B0F1] p-[3px] text-center text-[15px]"
                        maxlength="20">
                    <button id="confirmNewPassword" ref="confirmNewPasswordButton" @click="confirmNewPassword"
                        class="hidden ml-[20px] bg-none underline text-[#057DCD] text-[15px] border-none font-bold cursor-pointer">
                        Подтвердить
                    </button>
                    <a id="newPasswordErrors" ref="newPasswordErrors"
                        class="hidden text-red-500 ml-[50px] text-[13px]"></a>
                    <a id="newPasswordChangeSuccesfull" ref="newPasswordChangeSuccesfull"
                        class="hidden text-green-500 ml-[50px] text-[13px]"></a>
                </li>
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    Двухфакторная аутентификация: не подключена
                    <a href="#" class="text-[#057DCD] font-bold ml-[10px]">
                        Подключить
                    </a>
                </li>
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    <a href="#" class="text-[#057DCD] font-bold">
                        Активные сессии
                    </a>
                </li>
            </ul>
            <ul id="personalization" class="hidden list-none flex-col gap-[50px] pr-[50px] h-[30%]">
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    Тема: светлая
                </li>
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    Язык интерфейса: Русский
                </li>
            </ul>
            <ul id="stats" class="hidden list-none flex-col gap-[50px] pr-[50px] h-[30%]">
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    Создано опросов: {{ user.polls }}
                </li>
                <li class="border-b-[3px] border-[#43B0F1] pb-[15px] text-[16px]">
                    Пройдено опросов: {{ user.votes }}
                    <a @click="router.get('/history')" class="text-[#057DCD] font-bold ml-[10px] underline cursor-pointer">
                        История
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
