<template>
  <div>
    <div v-if="production.loaded()">
      <b-breadcrumb
        v-if="breadcrumbs"
        :items="breadcrumbs" />
      <crud-toolbar
        resource-name="productions"
        :resource-id="this.$route.params.uid" />

      <h1>{{ production.getTitle() }}</h1>

      <img
        v-if="production.hasHeaderImg()"
        :src="production.getHeaderImgUrl()"
        :alt="production.getTitle()"
        class="img-responsive header-img">

      <p class="lead">
        {{ production.getExcerpt() }}
      </p>

      <vue-markdown :source="production.getDescription()" />

      <h2>{{ $t('production.events') }}</h2>

      <div class="table-responsive">
        <table class="table table-sm table-bordered table-clickable">
          <thead class="thead-light">
            <tr>
              <th>{{ $t('production.attr.title') }}</th>
              <th>{{ $t('event.attr.start_time') }}</th>
              <th>{{ $t('event.attr.end_time') }}</th>
              <th>{{ $t('event.attr.place') }}</th>
            </tr>
          </thead>
          <tbody
            v-if="production.hasEvents()">
            <tr
              v-for="event in production.getEvents()"
              :key="event.getUid()"
              @click="openEvent(event.getUid())">
              <td>{{ event.getTitle() || production.getTitle() }}</td>
              <td>{{ event.getStartTimeHuman() }}</td>
              <td>{{ event.getEndTimeHuman() }}</td>
              <td><span v-if="event.getPlace()">{{ event.getPlace().name }}</span></td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="2">
                {{ $t('production.no_events') }}
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4">
                <b-button
                  variant="primary"
                  @click="addEvent">
                  {{ $t('ui.add_new') }}
                </b-button>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <loading-spinner v-else />
  </div>
</template>

<script>
import VueMarkdown from 'vue-markdown';
import {Production} from '../../../models/production';

export default {
    components: {
        VueMarkdown
    },
    data() {
        return {
            production: new Production(),
            breadcrumbs: []
        };
    },
    mounted() {
        let self = this;
        axios.get(config.apiUrl + '/productions/' + this.$route.params.uid)
            .then(response => {
                self.production = new Production(response.data.data);

                this.breadcrumbs = [
                    {
                        text: this.$t('nav.productions'),
                        to: { name: 'productions' }
                    },
                    {
                        text: this.production.getTitle(),
                        to: { name: 'production.details', params: {uid: this.production.getUid() } }
                    }
                ];
            });
    },
    methods: {
        formatTime(date) {
            return moment(date).format('Do MMMM HH:mm');
        },
        openEvent(uid) {
            this.$router.push({name: 'event.details', params: {uid: uid}});
        },
        addEvent() {
            let self = this;
            let startTime = moment().add(24, 'h').format();
            let endTime = moment().add(25, 'h').format();
            let uid = null;

            if (self.production.hasEvents()) {
                let lastEvent = self.production.getEvents()[self.production.getEvents().length - 1];
                startTime = lastEvent.getStartTime();
                endTime = lastEvent.getEndTime();
                uid = lastEvent.hasPlace() ? lastEvent.getPlace().uid : null;
            }

            axios.post(config.apiUrl + '/events', {
                production: {
                    uid: this.$route.params.uid
                },
                times: {
                    start: startTime,
                    end: endTime,
                },
                place: {
                    uid: uid
                }
            })
                .then(response => {
                    self.$router.push({
                        name: 'event.edit',
                        params: {uid: response.data.data.uid}
                    });
                });
        }
    }
};
</script>
