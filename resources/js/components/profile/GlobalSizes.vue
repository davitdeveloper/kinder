<template>
    <v-container fluid class="px-0">
      <v-card tile outlined>
        <v-data-table :headers="headers" :items="sizes">
          <template v-slot:top>
            <v-card tile flat class="border-bottom">
              <v-toolbar flat>
                <v-toolbar-title>Sizes</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new size</v-btn>
              </v-toolbar>
            </v-card>
          </template>
    
          <template v-slot:item.action="{ item }">
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <v-icon
                  class="mr-2"
                  color="yellow darken-3"
                  v-on="on"
                  @click="open(item, 2)"
                >mdi-pencil-outline</v-icon>
              </template>
              <span>Update</span>
            </v-tooltip>
    
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <v-icon color="red" v-on="on" @click="remove(item)">mdi-delete-outline</v-icon>
              </template>
              <span>Delete</span>
            </v-tooltip>
          </template>
        </v-data-table>
    
        <v-dialog v-model="dialog" max-width="50%" persistent>
          <v-card>
            <v-card-title>{{ title }}</v-card-title>
            <v-form v-model="valid">
              <v-container>
                <v-row no-gutters justify="space-around">
                  <v-col cols="5">
                    <v-card tile flat>
                      <v-select
                        v-model="size.type"
                        :rules="nameRules"
                        :items="types"
                        item-text="name"
                        menu-props="offsetY"
                        label="տեսակ"
                        color="#347cbb"
                        item-color="#347cbb"
                        outlined
                        dense
                        clearable
                        open-on-clear
                      ></v-select>
                    </v-card>
                  </v-col>
                  <v-col cols="5">
                    <v-card tile flat>
                      <v-text-field
                        v-model="size.value"
                        :rules="nameRules"
                        label="արժեք"
                        color="#347cbb"
                        outlined
                        dense
                        clearable
                      ></v-text-field>
                    </v-card>
                  </v-col>
                </v-row>
                <v-row no-gutters justify="space-around">
                  <v-col cols="5">
                    <v-card tile flat>
                      <v-card tile flat>
                        <v-text-field
                          v-model="size.rang"
                          :rules="nameRules"
                          label="հերթականություն"
                          color="#347cbb"
                          outlined
                          dense
                          clearable
                        ></v-text-field>
                      </v-card>
                    </v-card>
                  </v-col>
                  <v-col cols="5"></v-col>
                </v-row>
              </v-container>
            </v-form>
            {{ errorMessage }}
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn text @click="dialog = false">cancel</v-btn>
              <v-btn color="#347cbb" dark width="90" @click="save">save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-card>
    </v-container>
</template>

<script>
import axios from "axios";
import Size from "../../models/Size";

export default {
    name: "GlobalSizes",
    data: () => ({
        headers: [
            { text: "Type", value: "type" },
            { text: "Value", value: "value" },
            { text: "Rang", value: "rang" },
            { text: "Action", value: "action", sortable: false }
        ],
        sizes: [],
        types: [
            { name: "Top" },
            { name: "Shoe" },
            { name: "Pant" },
            { name: "Accessory" }
        ],
        size: {
            value: "",
            type: "",
            rang: ""
        },
        dialog: false,
        mode: 0,
        errorMessage: "",
        valid: false,
        nameRules: [v => !!v || "This field is required"]
    }),

    computed: {
        title() {
            return this.mode === 1 ? "New Size" : "Update Size";
        }
    },

    methods: {
        getSizes() {
            axios.get(`/api/profile/global-sizes`)
                .then(res => (this.sizes = res.data))
                .catch(err => console.error(err.response.data.message));
        },

        open(item, mode) {
            this.size = item;
            this.mode = mode;
            this.dialog = true;
        },

        save() {
            if (this.mode === 1) {
                axios.post(`/api/profile/global-size/create`, this.size)
                    .then(res => {
                      this.sizes.unshift(res.data);
                      this.size = {
                        value: "",
                        type: "",
                        rang: ""
                      };
                      this.dialog = false;
                    })
                    .catch(err => (this.errorMessage = err.response.data.message));
            } else {
                axios.put(`/api/profile/global-size/update/${this.size.id}`, this.size)
                    .then(res => {
                      let index = this.sizes.findIndex(size => size.id === res.data.id);
                      this.sizes.splice(index, 1, res.data);
                      this.size = {
                        value: "",
                        type: "",
                        rang: ""
                      };
                      this.dialog = false;
                    })
                    .catch(err => (this.errorMessage = err.response.data.message));
            }
        },

        remove(item) {
            confirm("Are you sure you want to delete this size?") &&
                axios
                  .delete(`/api/profile/global-size/delete/${item.id}`)
                  .then(res => {
                    let index = this.sizes.findIndex(size => size.id === res.data.id);
                    this.sizes.splice(index, 1);
                  })
                  .catch(err => console.error(err.response.data.message));
        }
    },

    watch: {
        ["size.type"] (val) {
            if (val) {
                this.getGlobalSizes();
            } else {
                this.globalSizes = [];
            }
        },

        selectedSizes (val) {
            if (this.size.type === "Top") {
                this.topSizes = [];
                val.forEach(selectedSize => {
                    this.topSizes.push(new TopSize(Object.assign(this.size, { size_id: selectedSize })));
                });
            } else if (this.size.type === "Pants") {
                this.pantsSizes = [];
                val.forEach(selectedSize => {
                    this.pantsSizes.push(new PantsSize(Object.assign(this.size, { size_id: selectedSize })));
                });
            } else {
                this.shoeSizes = [];
                val.forEach(selectedSize => {
                    this.shoeSizes.push(new ShoeSize(Object.assign(this.size, { size_id: selectedSize })));
                });
            }
        }
    },

    created() {
        // this.getManufacturers();
        this.getSizes();
    }
};
</script>

<style scoped>
.border {
  border: 1px solid black;
}

.border-bottom {
  border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
</style>

