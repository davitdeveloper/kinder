<template>
    <section>
        <v-container>
            <template>
                <v-card text tile>
                    <v-card-title >
                        <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">Նոր ապրանք</v-btn>
                    </v-card-title>

                    <v-card-text>
                        <v-data-table :loading="loading" loading-text="Loading... Please wait" :headers="headers" :items="products">
                            <template v-slot:item.image="{ item }">
                                <div class="p-2 ">
                                    <img class="tbl-img"  v-if="item.images.length" :src="item.images[0].image" height="100px"></img>
                                </div>
                            </template>
                            <template v-slot:item.price="{ item }">
                                <div class="p-2 ">
                                    {{ item.price }} դր․
                                </div>
                            </template>

                            <template v-slot:item.action="{ item }">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-icon class="mr-2" color="yellow darken-3" v-on="on" @click="openUpdate(item)">
                                            mdi-pencil-outline
                                        </v-icon>
                                    </template>
                                    <span>Փոփոխել</span>
                                </v-tooltip>

                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-icon color="red" v-on="on" @click="remove(item)">
                                            mdi-delete-outline
                                        </v-icon>
                                    </template>
                                    <span>Ջնջել</span>
                                </v-tooltip>

                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-icon class="mr-2" color="green" v-on="on" @click="upInTable(item)">
                                            mdi-arrow-up-thick
                                        </v-icon>
                                    </template>
                                    <span>Թարմացնել</span>
                                </v-tooltip>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
                <v-dialog v-model="dialog" max-width="70%" persistent>
                    <v-stepper v-model="e1">
                        <v-stepper-header>
                            <template v-for="n in steps">
                                <v-stepper-step
                                    :key="`${n}-step`"
                                    :complete="e1 > n"
                                    :step="n"
                                >
                                    <h3 v-if="n === 1">Կատեգորիա</h3>
                                    <h3 v-if="n === 2">Ապրանք</h3>
                                    <h3 v-if="n === 3">Դիտել</h3>
                                </v-stepper-step>

                                <v-divider
                                    v-if="n !== steps"
                                    :key="n"
                                ></v-divider>
                            </template>
                        </v-stepper-header>

                        <v-stepper-items>
                            <v-stepper-content
                                v-for="n in steps"
                                :key="`${n}-content`"
                                :step="n"
                            >

                                <v-card
                                    v-if="n === 1"
                                    class="mb-12"
                                >
                                    <v-card-text>
                                        <v-row >
                                            <v-col cols="8">
                                                <v-window v-model="step">
                                                    <v-window-item :value="1">
                                                        <v-list>
                                                            <v-list-item-group v-model="category" color="#347cbb">
                                                                <v-list-item
                                                                    v-for="item in menu"
                                                                    :key="'category' + item.id"
                                                                    :value="item"
                                                                    @click="step++"
                                                                >
                                                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                                                </v-list-item>
                                                            </v-list-item-group>
                                                        </v-list>
                                                    </v-window-item>

                                                    <v-window-item :value="2">
                                                        <v-row no-gutters align="center">
                                                            <v-col cols="2">
                                                                <v-btn icon @click="goCategory">
                                                                    <v-icon>mdi-arrow-left</v-icon>
                                                                </v-btn>
                                                            </v-col>
                                                            <v-col>
                                                                <p class="ma-0">{{ category.title }}</p>
                                                            </v-col>
                                                        </v-row>

                                                        <v-list>
                                                            <v-list-item-group v-model="subCategory" color="#347cbb">
                                                                <v-list-item
                                                                    v-for="subItem in category.children"
                                                                    :key="'subCategory' + subItem.id"
                                                                    :value="subItem"
                                                                    @click="step++"
                                                                >
                                                                    <v-list-item-title v-text="subItem.title"></v-list-item-title>
                                                                </v-list-item>
                                                            </v-list-item-group>
                                                        </v-list>
                                                    </v-window-item>

                                                    <v-window-item :value="3">
                                                        <v-row no-gutters align="center">
                                                            <v-col cols="2">
                                                                <v-btn icon @click="goSubCategory">
                                                                    <v-icon>mdi-arrow-left</v-icon>
                                                                </v-btn>
                                                            </v-col>
                                                            <v-col>
                                                                <p class="ma-0">{{ subCategory.title }}</p>
                                                            </v-col>
                                                        </v-row>

                                                        <v-list>
                                                            <v-list-item-group v-model="subSubCategory" color="#347cbb">
                                                                <v-list-item
                                                                    v-for="subSubItem in subCategory.children"
                                                                    :key="'subSubCategory' + subSubItem.id"
                                                                    :value="subSubItem"
                                                                >
                                                                    <v-list-item-title v-text="subSubItem.title"></v-list-item-title>
                                                                </v-list-item>
                                                            </v-list-item-group>
                                                        </v-list>
                                                    </v-window-item>
                                                </v-window>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>

                                <v-card
                                    v-if="n === 2"
                                    class="mb-12"
                                >
                                    <v-card-text>
                                        <v-row no-gutters justify="space-between">
                                            <v-col cols="5">
                                                <v-card tile flat>
                                                    <v-text-field
                                                        v-model="product.title"
                                                        label="անուն"
                                                        color="#347cbb"
                                                        outlined
                                                        dense
                                                        clearable
                                                    ></v-text-field>
                                                </v-card>
                                            </v-col>
                                            <v-col cols="5">
                                                <v-menu :close-on-content-click="false" nudge-bottom="40">
                                                    <template v-slot:activator="{ on }">
                                                        <v-card tile flat>
                                                            <v-text-field
                                                                v-model="product.color"
                                                                label="գույն"
                                                                color="#347cbb"
                                                                outlined
                                                                dense
                                                                v-on="on"
                                                            ></v-text-field>
                                                        </v-card>
                                                    </template>

                                                    <v-card>
                                                        <v-card-title>Pick a color</v-card-title>
                                                        <v-row justify="center">
                                                            <v-color-picker v-model="product.color" flat></v-color-picker>
                                                        </v-row>
                                                    </v-card>
                                                </v-menu>
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters justify="space-between">
                                            <v-col cols="5">
                                                <v-list>
                                                    <v-list-group
                                                        v-for="item in cit"
                                                        :key="item.id"
                                                    >
                                                        <template v-slot:activator>
                                                            <v-list-item-content>
                                                                <v-list-item-title v-text="item.name"></v-list-item-title>
                                                            </v-list-item-content>
                                                        </template>
                                                            <v-list-item
                                                                v-for="subItem in item.children"
                                                                :key="subItem.name"
                                                            >
                                                                <v-checkbox v-model="product.city_id" :label="subItem.name" :value="subItem.id"></v-checkbox>
                                                            </v-list-item>
                                                    </v-list-group>
                                                </v-list>
                                            </v-col>
                                            <v-col cols="5">
                                                <v-row justify="center">
                                                    <v-col cols="12">
                                                        <v-card tile flat>
                                                            <v-select
                                                                v-model="product.manufacturer.name"
                                                                :items="manufacturers"
                                                                item-text="name"
                                                                item-value="name"
                                                                menu-props="offsetY"
                                                                label="արտադրող"
                                                                color="#347cbb"
                                                                item-color="#347cbb"
                                                                outlined
                                                                dense
                                                                clearable
                                                                open-on-clear
                                                            >
                                                            </v-select>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                                <v-row v-if="manInput" justify="center">
                                                    <v-col cols="12">
                                                        <v-card tile flat>
                                                            <v-text-field
                                                                v-model="product.myManufacturer.name"
                                                                label="արտադրող"
                                                                color="#347cbb"
                                                                outlined
                                                                dense
                                                                clearable
                                                            ></v-text-field>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                                <v-row justify="center">
                                                    <v-col cols="12">
                                                        <v-card tile flat>
                                                            <v-select
                                                                v-model="product.condition"
                                                                :items="conditions"
                                                                item-text="name"
                                                                item-value="name"
                                                                menu-props="offsetY"
                                                                label="վիճակ"
                                                                color="#347cbb"
                                                                item-color="#347cbb"
                                                                outlined
                                                                dense
                                                                clearable
                                                                open-on-clear
                                                            >
                                                            </v-select>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                                <v-row justify="center">
                                                    <v-col cols="12">
                                                        <v-card tile flat>
                                                            <v-textarea
                                                                v-model="product.description"
                                                                solo
                                                                dense
                                                                name="description"
                                                                label="նկարագրություն"
                                                            ></v-textarea>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                                <v-row justify="center">
                                                    <v-col cols="12">
                                                        <v-card tile flat>
                                                            <v-text-field
                                                                v-model="product.price"
                                                                v-mask="'######'"
                                                                label="գին"
                                                                color="#347cbb"
                                                                outlined
                                                                dense
                                                                clearable
                                                            ></v-text-field>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                                <v-row justify="center">
                                                    <v-col cols="12">
                                                        <v-card tile flat>
                                                            <v-text-field
                                                                v-model="product.phone"
                                                                v-mask="'+(374)##-###-###'"
                                                                label="հեռախոսահամար"
                                                                color="#347cbb"
                                                                outlined
                                                                dense
                                                                clearable
                                                            ></v-text-field>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                                <v-row no-gutters justify="center">
                                                    <v-col cols="10">
                                                        <v-card tile flat>
                                                            <v-file-input
                                                                label="նկարներ"
                                                                color="#347cbb"
                                                                multiple
                                                                dense
                                                                outlined
                                                                @change="onFilesSelected"
                                                            ></v-file-input>
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters justify="center">
                                            <v-col cols="11">
                                                <v-card tile outlined>
                                                    <v-row no-gutters justify="space-around">
                                                        <v-col
                                                            v-for="(image, i) in product.images"
                                                            :key="i"
                                                            cols="3"
                                                        >
                                                            <v-card tile flat>
                                                                <v-img :src="image" contain></v-img>
                                                            </v-card>
                                                        </v-col>
                                                    </v-row>
                                                </v-card>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>

                                <v-card
                                    v-if="n === 3"
                                    class="mb-12"
                                >
                                    <v-row no-gutters justify="space-between" class="mt-8" style="display: flex">
                                        <v-col cols="4">
                                            <h1>{{product.title}}</h1>
<!--                                                <v-card tile flat-->
<!--                                                        v-for="(image, i) in product.images"-->
<!--                                                        :key="i"-->
<!--                                                >-->
<!--                                                    <v-img :src="image" contain></v-img>-->
<!--                                                </v-card>-->
                                            <v-carousel hide-delimiters v-model="activeImage">
                                                <v-carousel-item
                                                    v-for="(image, i) in product.images"
                                                    :key="i"
                                                    :src="image"
                                                >
                                                </v-carousel-item>
                                            </v-carousel>
                                            <v-row>
                                                <v-col
                                                    cols="2"
                                                    v-for="(image, i) in product.images"
                                                    :key="i"
                                                >
                                                    <v-img @click="active(i)" :src="image" style="height: 50px;cursor: pointer">
                                                    </v-img>
                                                </v-col>

                                            </v-row>
                                        </v-col>
                                        <v-col cols="7">
                                            <v-toolbar-title class="gin">
                                                <span class="red--text mr-7">{{product.price}}դր․</span>
                                            </v-toolbar-title>

                                            <v-row class="mt-8" no-gutters align="center">
                                                <v-col cols="12" class="mr-3" style="display: flex">
                                                    <span class="grey--text pa-0" style="font-size: 20px">Գույն:</span>
                                                    <div class="v-color" :style="{ background: product.color}"></div>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mt-8" no-gutters align="center">
                                                <v-col cols="12" class="mr-3">
                                                    <span class="grey--text pa-0" style="font-size: 20px">Արտադրող:</span>
                                                    <span>{{product.manufacturer.name}}</span>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mt-8" no-gutters align="center">
                                                <v-col cols="12" class="mr-3">
                                                    <span class="grey--text pa-0" style="font-size: 20px">Վիճակ:</span>
                                                    <span>{{product.condition}}</span>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mt-8" no-gutters align="center">
                                                <v-col cols="12" class="mr-3">
                                                    <span class="grey--text pa-0" style="font-size: 20px">Նկարագրություն:</span>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mt-8" no-gutters align="center">
                                                <v-col cols="12" class="mr-3">
                                                    <span>{{product.description}}</span>
                                                </v-col>
                                            </v-row>
                                            <v-row class="mt-8" no-gutters align="center">
                                                <v-col cols="12" class="mr-3">
                                                    <span class="grey--text pa-0" style="font-size: 20px">Հեռախոսահամար:</span>
                                                    <span>{{product.phone}}</span>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-card>

                                <v-row>
                                    <v-col cols="6" style="display: flex;justify-content: flex-start">
                                        <v-btn :disabled="n === 1" text @click="backStep(n)">Back</v-btn>
                                        <v-btn
                                            :disabled="product.category_ids.length < 1"
                                            v-if="n!==3"
                                            color="primary"
                                            @click="nextStep(n)"
                                        >
                                            Continue
                                        </v-btn>
                                    </v-col>

                                    <v-col cols="6" style="display: flex;justify-content: flex-end">
                                        <v-btn style="" text @click="dialog = false">Cancel</v-btn>
                                        <v-btn
                                            v-if="n === 3"
                                            color="primary"
                                            @click="save"
                                        >
                                            Save
                                        </v-btn>
                                    </v-col>
                                </v-row>

                            </v-stepper-content>
                        </v-stepper-items>
                    </v-stepper>
                </v-dialog>
                <v-dialog v-model="updateDialog" max-width="70%" persistent>
                    <v-card>
                        <v-card-title>
                           Update Product
                        </v-card-title>
                        <v-form >
                            <v-container>
                                    <v-card-text>
                                        <v-row no-gutters justify="space-between">
                                            <v-col cols="5">
                                                <v-card tile flat>
                                                    <v-text-field
                                                        v-model="product.title"
                                                        label="անուն"
                                                        color="#347cbb"
                                                        outlined
                                                        dense
                                                        clearable
                                                    ></v-text-field>
                                                </v-card>
                                            </v-col>
                                            <v-col cols="5">
                                                <v-menu :close-on-content-click="false" nudge-bottom="40">
                                                    <template v-slot:activator="{ on }">
                                                        <v-card tile flat>
                                                            <v-text-field
                                                                v-model="product.color"
                                                                label="գույն"
                                                                color="#347cbb"
                                                                outlined
                                                                dense
                                                                v-on="on"
                                                            ></v-text-field>
                                                        </v-card>
                                                    </template>

                                                    <v-card>
                                                        <v-card-title>Pick a color</v-card-title>
                                                        <v-row justify="center">
                                                            <v-color-picker v-model="product.color" flat></v-color-picker>
                                                        </v-row>
                                                    </v-card>
                                                </v-menu>
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters justify="space-between">
                                            <v-col cols="5">
                                                <v-list>
                                                    <v-list-group
                                                        v-for="item in cit"
                                                        :key="item.id"
                                                    >
                                                        <template v-slot:activator>
                                                            <v-list-item-content>
                                                                <v-list-item-title v-text="item.name"></v-list-item-title>
                                                            </v-list-item-content>
                                                        </template>
                                                        <v-list-item
                                                            v-for="subItem in item.children"
                                                            :key="subItem.name"
                                                        >
                                                            <v-checkbox v-model="product.city_id" :label="subItem.name" :value="subItem.id"></v-checkbox>
                                                        </v-list-item>
                                                    </v-list-group>
                                                </v-list>
                                            </v-col>
                                            <v-col cols="5">
                                                <v-window v-model="step">
                                                    <v-window-item :value="1">
                                                        <v-list>
                                                            <v-list-item-group v-model="category" color="#347cbb">
                                                                <v-list-item
                                                                    v-for="item in menu"
                                                                    :key="'category' + item.id"
                                                                    :value="item"
                                                                    @click="step++"
                                                                >
                                                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                                                </v-list-item>
                                                            </v-list-item-group>
                                                        </v-list>
                                                    </v-window-item>

                                                    <v-window-item :value="2">
                                                        <v-row no-gutters align="center">
                                                            <v-col cols="2">
                                                                <v-btn icon @click="goCategory">
                                                                    <v-icon>mdi-arrow-left</v-icon>
                                                                </v-btn>
                                                            </v-col>
                                                            <v-col>
                                                                <p class="ma-0">{{ category.title }}</p>
                                                            </v-col>
                                                        </v-row>

                                                        <v-list>
                                                            <v-list-item-group v-model="subCategory" color="#347cbb">
                                                                <v-list-item
                                                                    v-for="subItem in category.children"
                                                                    :key="'subCategory' + subItem.id"
                                                                    :value="subItem"
                                                                    @click="step++"
                                                                >
                                                                    <v-list-item-title v-text="subItem.title"></v-list-item-title>
                                                                </v-list-item>
                                                            </v-list-item-group>
                                                        </v-list>
                                                    </v-window-item>

                                                    <v-window-item :value="3">
                                                        <v-row no-gutters align="center">
                                                            <v-col cols="2">
                                                                <v-btn icon @click="goSubCategory">
                                                                    <v-icon>mdi-arrow-left</v-icon>
                                                                </v-btn>
                                                            </v-col>
                                                            <v-col>
                                                                <p class="ma-0">{{ subCategory.title }}</p>
                                                            </v-col>
                                                        </v-row>

                                                        <v-list>
                                                            <v-list-item-group v-model="subSubCategory" color="#347cbb">
                                                                <v-list-item
                                                                    v-for="subSubItem in subCategory.children"
                                                                    :key="'subSubCategory' + subSubItem.id"
                                                                    :value="subSubItem"
                                                                >
                                                                    <v-list-item-title v-text="subSubItem.title"></v-list-item-title>
                                                                </v-list-item>
                                                            </v-list-item-group>
                                                        </v-list>
                                                    </v-window-item>
                                                </v-window>
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters justify="space-between">
                                            <v-col cols="5">
                                                <v-card tile flat>
                                                    <v-select
                                                        v-model="product.manufacturer.name"
                                                        :items="manufacturers"
                                                        item-text="name"
                                                        item-value="name"
                                                        menu-props="offsetY"
                                                        label="արտադրող"
                                                        color="#347cbb"
                                                        item-color="#347cbb"
                                                        outlined
                                                        dense
                                                        clearable
                                                        open-on-clear
                                                    >
                                                    </v-select>
                                                </v-card>
                                            </v-col>
                                            <v-col cols="5">
                                                <v-card tile flat>
                                                    <v-select
                                                        v-model="product.condition"
                                                        :items="conditions"
                                                        item-text="name"
                                                        item-value="name"
                                                        menu-props="offsetY"
                                                        label="վիճակ"
                                                        color="#347cbb"
                                                        item-color="#347cbb"
                                                        outlined
                                                        dense
                                                        clearable
                                                        open-on-clear
                                                    >
                                                    </v-select>
                                                </v-card>
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters justify="space-between">
                                            <v-col  cols="5">
                                                <v-card v-if="manInput" tile flat>
                                                    <v-text-field
                                                        v-model="product.myManufacturer.name"
                                                        label="արտադրող"
                                                        color="#347cbb"
                                                        outlined
                                                        dense
                                                        clearable
                                                    ></v-text-field>
                                                </v-card>
                                            </v-col>
                                            <v-col cols="5">

                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters justify="space-between">
                                            <v-col cols="5">
                                                <v-card tile flat>
                                                    <v-text-field
                                                        v-model="product.price"
                                                        v-mask="'######'"
                                                        label="գին"
                                                        color="#347cbb"
                                                        outlined
                                                        dense
                                                        clearable
                                                    ></v-text-field>
                                                </v-card>
                                            </v-col>
                                            <v-col cols="5">
                                                <v-card tile flat>
                                                    <v-text-field
                                                        v-model="product.phone"
                                                        v-mask="'+(374)##-###-###'"
                                                        label="հեռախոսահամար"
                                                        color="#347cbb"
                                                        outlined
                                                        dense
                                                        clearable
                                                    ></v-text-field>
                                                </v-card>
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters justify="space-between">
                                                <v-col cols="5">
                                                    <v-card tile flat>
                                                        <v-file-input
                                                            label="նկարներ"
                                                            color="#347cbb"
                                                            multiple
                                                            dense
                                                            outlined
                                                            clearable
                                                            @change="onFilesSelected"
                                                        ></v-file-input>
                                                    </v-card>
                                                </v-col>
                                                <v-col cols="5">
                                                    <v-card tile flat>
                                                        <v-textarea
                                                            v-model="product.description"
                                                            solo
                                                            dense
                                                            name="description"
                                                            label="նկարագրություն"
                                                        ></v-textarea>
                                                    </v-card>
                                                </v-col>
                                            </v-row>
                                        <v-row no-gutters justify="center">
                                            <v-col cols="11">
                                                <v-card tile outlined>
                                                    <v-row no-gutters justify="space-around">
                                                        <v-col
                                                            v-for="(image, i) in product.images"
                                                            :key="i"
                                                            cols="3"
                                                        >
                                                            <v-card tile flat>
                                                                <v-img v-if="typeof(image) === 'string'" :src="image" contain max-height="150px">
                                                                    <div style="display:flex;justify-content:flex-end">

                                                                        <v-tooltip bottom>
                                                                            <template v-slot:activator="{ on }">
                                                                                <v-btn icon v-on="on"  @click="delImg(i,image.id)">
                                                                                    <v-icon style="color:red">mdi-window-close</v-icon>
                                                                                </v-btn>
                                                                            </template>

                                                                            <span class="pa-3">Delete Image</span>
                                                                        </v-tooltip>
                                                                    </div>
                                                                </v-img>
                                                                <v-img v-if="typeof (image) === 'object'" :src="image.image" contain max-height="150px">
                                                                    <div style="display:flex;justify-content:flex-end">

                                                                        <v-tooltip bottom>
                                                                            <template v-slot:activator="{ on }">
                                                                                <v-btn icon v-on="on"  @click="delImg(i,image.id)">
                                                                                    <v-icon style="color:red">mdi-window-close</v-icon>
                                                                                </v-btn>
                                                                            </template>

                                                                            <span class="pa-3">Delete Image</span>
                                                                        </v-tooltip>
                                                                    </div>
                                                                </v-img>
                                                            </v-card>
                                                        </v-col>
                                                    </v-row>
                                                </v-card>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                            </v-container>
                        </v-form>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="cancel">cancel</v-btn>
                            <v-btn color="#347cbb" dark width="90" @click="update">update</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </template>
        </v-container>
    </section>
</template>

<script>

    import axios from "axios";

    export default {
        name: "MyInfo",
        data:() => ({
            loading: true,
            e1: 1,
            steps: 3,
            step: 1,
            headers: [
                { text: "Title", value: "title" },
                { text: "Image", value: "image", sortable: false },
                { text: "Price", value: "price", sortable: false  },
                { text: "Actions", value: "action"},
            ],
            products: [],
            product: {
                id: null,
                category_ids: [],
                title: '',
                description: '',
                price: '',
                city_id: null,
                color: '',
                manufacturer: {name:''},
                myManufacturer: {name:''},
                condition: '',
                imageFiles: [],
                images: [],
                phone: '',
            },
            dialog: false,
            updateDialog: false,
            colors: [],
            cit: [],
            manufacturers: [],
            conditions : [
                {name: 'Նոր'},
                {name: 'Օգտագործված'},
            ],
            manInput: false,
            activeImage: null,
            category: {},
            subCategory: {},
            subSubCategory: {},
        }),
        computed: {
            menu () {
                return this.$store.state.upperMenu;
            }
        },

        watch: {
            subSubCategory(val) {
                if (val) {
                    if (val.id) {
                        // this.productModel.category_ids = [];
                        this.product.category_ids.push(this.category.id);
                        this.product.category_ids.push(this.subCategory.id);
                        this.product.category_ids.push(val.id);
                    }
                } else {
                    this.product.category_ids = [];
                }
            },
            steps (val) {
                if (this.e1 > val) {
                    this.e1 = val
                }
            },
            ['product.manufacturer.name'](val){
                if(val){
                    if(val === 'Other'){
                        this.manInput = true;
                    }else{
                        this.manInput = false;
                    }
                }else{
                    this.manInput = false;
                }
            },
        },

        methods:{
            goCategory() {
                this.category = {};
                this.step--;
            },

            goSubCategory() {
                this.subCategory = {};
                this.step--;
            },
            active(index){
                this.activeImage = index;
            },
            upInTable(item){
                axios.post(`/api/app/own-product/up-in-list/${item.id}/${this.$store.state.auth.user.id}`)
                    .then(res =>  {
                        this.products = res.data.products;
                    })
                    .catch(err => {
                        this.errMessage = err.response.data;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            },
            onFilesSelected (event) {
                this.product.imageFiles = event;
                this.product.imageFiles.forEach(imageFile => {
                    const reader = new FileReader();
                    reader.readAsDataURL(imageFile);
                    reader.onload = e => this.product.images.push(e.target.result);
                });
            },
            createCitiesMenu(cities) {
                let cityMenu = cities.filter(cit => cit.region_id === null);
                cityMenu = this.createTree(cityMenu, cities);
                this.cit = cityMenu;

            },
            createTree(qaxaqner, globals) {
                qaxaqner.forEach(city => {
                    city.children = globals.filter(global => global.region_id === city.id);
                });
                return qaxaqner;
            },

            getInfo () {
                axios.get('/api/app/own-product/get-info')
                    .then(res =>  {
                        this.colors = res.data.colors;
                        this.manufacturers = res.data.manufacturers;
                        this.manufacturers.push({name: 'Other'});
                        this.createCitiesMenu(res.data.cities);
                    })
                    .catch(err => {
                        this.errMessage = err.response.data;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            },

            nextStep (n) {
                this.e1 = n + 1;
            },
            backStep (n) {
                this.e1 = n - 1;
            },
            next(){
                this.active_tab += 1;
            },
            back(){
                this.active_tab -= 1;
            },
            open(item) {
                this.dialog = true;
            },
            openUpdate(item) {
                if(item.color){
                    this.product.color = item.color
                }
                let man = this.manufacturers.find(manufacturer => manufacturer.name === item.manufacturer);
                if(!man){
                    this.product.manufacturer.name = "Other";
                    this.product.myManufacturer.name = item.manufacturer;
                }
                else{
                    this.product.manufacturer.name = item.manufacturer;
                }
                this.product.id = item.id;
                this.product.user_id = item.user_id;
                this.product.category_ids = item.category_ids;
                this.product.title = item.title;
                this.product.description = item.description;
                this.product.price = item.price;
                this.product.city_id = item.city_id;
                this.product.condition = item.condition;
                this.product.imageFiles = [];
                this.product.images = item.images;
                this.product.phone = item.phone;
                this.updateDialog = true;
            },
            save () {
                const fd = new FormData();

                fd.append("product", []);
                fd.append("product[user_id]", this.$store.state.auth.user.id);
                fd.append("product[title]", this.product.title);
                fd.append("product[city_id]", this.product.city_id);
                fd.append("product[color]", this.product.color);
                fd.append("product[manufacturer]", this.product.manufacturer.name);
                fd.append("product[my_manufacturer]", this.product.myManufacturer.name);
                fd.append("product[condition]", this.product.condition);
                fd.append("product[description]", this.product.description);
                fd.append("product[price]", this.product.price);
                fd.append("product[phone]", this.product.phone);

                fd.append("category_ids", []);
                this.product.category_ids.forEach((model, i) => {
                    fd.append(`category_ids[${i}]`, model)
                });

                fd.append("images", []);
                this.product.imageFiles.forEach((image, i) => {
                    fd.append(`images[${i}]`, image);
                });

                axios.post(`/api/app/own-product/create`,fd)
                    .then(res =>  {
                        this.products.push(res.data);
                        this.product = {
                            id: null,
                            category_ids: [],
                            title: '',
                            description: '',
                            price: '',
                            city_id: null,
                            color: '',
                            manufacturer: {name:''},
                            myManufacturer: {name:''},
                            condition: '',
                            imageFiles: [],
                            images: [],
                            phone: '',
                        };
                        this.dialog = false;
                    })
                    .catch(err => {
                        this.errMessage = err.response.data;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            },
            update () {
                const fd = new FormData();

                fd.append("product", []);
                fd.append("product[user_id]", this.$store.state.auth.user.id);
                fd.append("product[title]", this.product.title);
                fd.append("product[city_id]", this.product.city_id);
                fd.append("product[color]", this.product.color);
                fd.append("product[manufacturer]", this.product.manufacturer.name);
                fd.append("product[my_manufacturer]", this.product.myManufacturer.name);
                fd.append("product[condition]", this.product.condition);
                fd.append("product[description]", this.product.description);
                fd.append("product[price]", this.product.price);
                fd.append("product[phone]", this.product.phone);

                fd.append("category_ids", []);
                this.product.category_ids.forEach((model, i) => {
                    fd.append(`category_ids[${i}]`, model)
                });

                fd.append("images", []);
                this.product.imageFiles.forEach((image, i) => {
                    fd.append(`images[${i}]`, image);
                });
                fd.append("_method", 'PUT');
                axios.post(`/api/app/own-product/update/${this.product.id}`,fd)
                    .then(res =>  {
                        // location.reload();
                    })
                    .catch(err => {
                        this.errMessage = err.response.data;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            },
            cancel () {
                this.updateDialog = false;
                this.product = {
                    id: null,
                    category_ids: [],
                    title: '',
                    description: '',
                    price: '',
                    city_id: null,
                    color: '',
                    manufacturer: {name:''},
                    myManufacturer: {name:''},
                    condition: '',
                    imageFiles: [],
                    images: [],
                    phone: '',
                };
            },
            delImg (index,id) {
                if(id){
                    axios.delete(`/api/app/own-product/del-img/${id}`)
                        .then(res =>  {
                            this.product.images.splice(index, 1);
                        })
                        .catch();
                }else{
                    this.product.images.splice(index, 1);
                }
            },
            remove (item) {
                confirm("Համոզված եք որ ուզում եք ջնջել տվյալ հայտարարությունը?") &&
                axios.delete(`/api/app/own-product/delete/${item.id}`)
                    .then(res => {
                        let index = this.products.findIndex(product => product.id === res.data.id);
                        this.products.splice(index, 1);
                    })
                    .catch(err => console.error(err.response.data.message));
            },
        },
        created() {
            this.getInfo();

            if(this.$store.state.auth.user){
                return axios.get(`/api/app/own-product/get-my-product/${this.$store.state.auth.user.id}`)
                    .then(res =>  {
                        this.products = res.data.products;
                        this.loading =false;
                    })
                    .catch(err => {
                        this.errMessage = err.response.data.message;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            }else{
                window.location.href = '/';
            }
        }
    }
</script>

<style scoped>
    .petlya {
        height: 100px;
        background: url(/images/shape1.png) no-repeat;
        background-size: contain;
        position: relative;
    }
    .titer {
        position: absolute;
        right: -50px;
        top: -5px;
    }
    .gic {
        height: 2px;
        margin-top: 60px;
        background: url(/images/shape3.png);
        background-size: contain;
    }
    .myInfo {
        color: #4dc0a6;
        font-size: 3vw !important;
        position: absolute;
        top: 190px;
        left: 38%;
    }
    .tbl-img{
        max-height: 50px;
    }

    .petlya {
        position: relative;
        height: 100px;
        background: url(/images/shape1.png) no-repeat;
        background-size: contain;
    }

    .titer {
        position: absolute;
        right: -50px;
        top: -5px;
    }

    .apranqiAnun {
        color: #4dc0a6;
        font-size: 3vw !important;
        position: absolute;
        top: 45px;
        left: 75%;
    }

    .b_sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 30px;
        max-height: 800px;
    }

    .gin {
        position: relative;
        font-size: 55px;
    }

    .jnjoxGic {
        border: 1px solid grey;
        width: 135px;
        position: absolute;
        top: 40px;
        left: 115px;
        transform: rotate(5deg);
    }

    .timer {
        border: 3px dotted red;
        max-width: 300px;
        font-size: 20px;
        color: grey;
        margin-top: 10px;
        padding: 20px 0;
        text-align: center;
    }

    .pointer {
        cursor: pointer;
    }

    .b_centered {
        margin: auto;
        margin-top: 6px;
    }

    .b_active {
        border: 2px solid goldenrod !important;
    }

    .fontBig {
        font-size: 25px;
        margin-top: 25px;
    }

    .gic1 {
        border: 1px solid #347cbb;
        width: 80px;
        transform: rotate(92deg);
        position: absolute;
        top: 15px;
        left: -7px;
    }

    .gic2 {
        border: 1px solid #347cbb;
        width: 300px;
        position: absolute;
        transform: rotate(-2deg);
        bottom: -10px;
        left: -20px;
    }

    .cardImage {
        position: absolute;
        top: -10px;
        left: -17px;
    }

    .b_primary {
        color: #347cbb;
    }

    .v-text-field__slot input {
        text-align: center;
    }
    .v-color{
        height: 30px;
        width: 30px;
        margin-left: 20px;
    }
</style>
