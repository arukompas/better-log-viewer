<template>
    <div class="log-list py-5 h-full flex flex-col">
        <div>
            <div class="row" v-if="logData && file">
                <div class="col-auto">
                    <p class="text-right text-muted">
                        <small>
                            <span class="mr-3">Response Time: <strong>{{ logData && logData.response_time ? logData.response_time.toFixed(3) * 1000 : 'NULL' }} ms</strong></span> |
                            <span class="ml-3">Peak Memory: <strong>{{ logData && logData.response_peak_memory ? logData.response_peak_memory : 'NULL' | fileSize }}</strong></span>
                        </small>
                    </p>
                </div>
            </div>
            <div class="flex justify-between my-3" v-if="file">
                <div class="flex-1">
                    <btn v-for="(count, key) in levelCounts" 
                            :key="key" 
                            v-if="count.count" 
                            @click="toggleLevel(key)" 
                            class="m-1"
                            :active="levelActive[key]"
                            :type="count.level_class">
                        {{ key }}: <strong>{{ count.count }}</strong>
                    </btn>
                </div>
                <div class="flex-1">
                    <div class="width-full">
                        <input type="text" v-model="query" class="p-2 rounded shadow" style="width: 100%;" placeholder="Search...">
                    </div>
                </div>
            </div>

            <div class="flex justify-between mb-4 mt-5" v-if="file">
                <div>
                    <nav>
                        <paginate 
                            v-model="currentPage"
                            v-if="pages"
                            :page-count="pages"
                            :click-handler="getLogs"
                            :firstLastButton="true"
                            :prev-text="'Prev'"
                            :next-text="'Next'"
                            container-class="inline-flex list-reset bg-white shadow text-blue rounded w-auto font-sans"
                            :page-class="'block hover:text-white hover:bg-blue border-r border-grey-light px-3 py-2'"
                            active-class="text-white bg-blue border-r border-blue"
                            :page-link-class="'page-link'">
                        </paginate>
                    </nav>
                </div>

                <div class="relative">
                    <select v-model="perPage" class="block shadow appearance-none w-full border border-grey-lighter text-grey-darker py-2 px-4 pr-8 rounded leading-tight focus:outline-none bg-white focus:border-grey">
                        <option v-for="results in [10, 15, 20, 30, 50, 100]" :key="results" :value="results">{{ results }} per page</option>
                    </select>
                    <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="log-item-container overflow-y-scroll">
            <div v-if="logs && logCount > 0">
                <log-item :log="log" v-for="(log, index) in logs" :key="index"></log-item>
            </div>
            <h4 class="text-center" v-if="file && (!logs || logCount == 0)">No logs found for this criteria...</h4>
            <h4 class="text-center" v-if="!file">Please select a file first</h4>

            <div class="loader-overlay" v-show="loading">
                <div class="loader">
                    <spinner size="100"></spinner>
                </div>
            </div>
        </div>

        <div>
            <div class="flex justify-between mt-5" v-if="file">
                <div>
                    <nav>
                        <paginate 
                            v-model="currentPage"
                            v-if="pages"
                            :page-count="pages"
                            :click-handler="getLogs"
                            :firstLastButton="true"
                            :prev-text="'Prev'"
                            :next-text="'Next'"
                            container-class="inline-flex list-reset bg-white shadow text-blue rounded w-auto font-sans"
                            :page-class="'block hover:text-white hover:bg-blue border-r border-grey-light px-3 py-2'"
                            active-class="text-white bg-blue border-r border-blue"
                            :page-link-class="'page-link'">
                        </paginate>
                    </nav>
                </div>

                <div class="relative">
                    <select v-model="perPage" class="block shadow appearance-none w-full border border-grey-lighter text-grey-darker py-2 px-4 pr-8 rounded leading-tight focus:outline-none bg-white focus:border-grey">
                        <option v-for="results in [10, 15, 20, 30, 50, 100]" :key="results" :value="results">{{ results }} per page</option>
                    </select>
                    <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import debounce from 'lodash/debounce';

export default {
    data() {
        return {
            file: null,
            logData: {},
            perPage: 10,
            currentPage: 1,
            loading: false,
            callToken: null,
            query: '',
            levelActive: {
                debug: true,
                info: true,
                notice: true,
                warning: true,
                error: true,
                critical: true,
                alert: true,
                emergency: true,
                processed: true,
                failed: true,
            },
        }
    },

    mounted() {
        this.$root.event_bus.$on('file-changed', file => {
            this.file = file;
        });

        this.$root.event_bus.$on('file-deleted', file => {
            if (this.file.name == file.name) {
                this.file = null;
                this.logData = {};
            }
        })
    },

    watch: {
        file() {
            this.currentPage = 1;
            this.getLogs();
        },

        query() {
            this.getLogs();
        },

        currentPage() {
            this.$root.event_bus.$emit('page-changed', this.currentPage);
        },

        perPage() {
            this.getLogs();
        }
    },

    computed: {
        levelCounts() {
            return this.file.counts;
        },

        fileName() {
            return this.file ? this.file.name : null;
        },

        logs() {
            return this.logData.data;
        },

        pages() {
            return this.logData.last_page ? this.logData.last_page : 0;
        },

        activeLevelsQuery() {
            let activeLevels = [];
            Object.keys(this.levelActive).forEach(level => {
                if (this.levelActive[level] && this.levelCounts[level].count) {
                    activeLevels.push(level);
                }
            });

            return activeLevels.join(',');
        },

        logCount() {
            if (typeof this.logs == 'object') {
                return Object.keys(this.logs).length;
            } else if (typeof this.logs == 'array') {
                return this.logs.length;
            }

            return 0;
        }
    },

    methods: {
        getLogs: debounce(function() {
            if (this.fileName) {
                let CancelToken = axios.CancelToken;

                if (this.callToken) {
                    this.callToken.cancel();
                }

                this.callToken = CancelToken.source();
                this.loading = true;

                axios.get(`${window.route_path}api/file/${this.fileName}?page=${this.currentPage}&perPage=${this.perPage}&levels=${this.activeLevelsQuery}&query=${this.query}`, { cancelToken: this.callToken.token })
                    .then(({data}) => {
                        this.loading = false;
                        this.logData = data;
                        this.callToken = null;

                        if (data.last_page < this.currentPage) {
                            this.currentPage = data.last_page;
                            this.getLogs();
                        }
                    }).catch(error => {
                        this.loading = false;
                        this.callToken = null;
                    });
            }
        }, 150),

        toggleLevel(level) {
            this.levelActive[level] = !this.levelActive[level];
            this.getLogs();
        }
    },
}
</script>

<style>

.loader-overlay {
    border-radius: 5px;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.9);
}

.log-item-container {
    position: relative;
}

.loader {
    height: 100%;
    width: 100%;
    color: black;
    font-size: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
