<template>
    <div class="wrapper-table-appointments">

        <modal-online-appointment :year="$route.params.year" :month="$route.params.month" :bikes='bikes'
                                  ref="modalOnlineAppointment"></modal-online-appointment>

        <div class="message" v-html="message"></div>
        <div v-show="loader" class="loader-gif">
            <img src="/img/tpl_img/ajax.gif" class="ajax-loader"/>
        </div>

        <div style="margin-bottom: 10px;" class="filter-table">

            <div v-if="years" class="btn-group btn-group-toggle list-years" data-toggle="buttons">
                <router-link v-bind:key="key" v-for="(year,key) in years" class="btn btn-primary" :to=linkYear(year)
                             v-text="year"></router-link>
            </div>

            <div style="margin-top: 10px;" v-if="months" class="list-months">
                <router-link v-bind:key="key" v-for="(month,key) in months" class="btn btn-primary"
                             :to=linkYearMonth(month.year,month.number) v-text="month.name"></router-link>
            </div>


        </div>


        <table class="table responsive-table table-bordered table-hover table-striped">
            <thead class="thead-light">
            <tr>
                <th>
                    <div class="th-thead th-thead-day">
                        День
                    </div>
                </th>
                <th>
                    <div class="th-thead th-thead-date">
                        Дата
                    </div>
                </th>
                <th>
                    <div class="th-thead th-thead-bike">
                        Техника
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        8/9
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        9/10
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        10/11
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        11/12
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        12/13
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        13/14
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        14/15
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        15/16
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        16/17
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        17/18
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        18/19
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        19/20
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        20/21
                    </div>
                </th>
                <th>
                    <div class="th-time-work">
                        21/22
                    </div>
                </th>
            </tr>
            </thead>

            <tbody :ref="setIdTr(day.date_record)" v-bind:id="setIdTr(day.date_record)"
                   v-bind:class="setClassTr(day.date_record)"
                   v-for="(day, key) in days">
            <tr v-for="(bike, index) in day.bikes">


                <td class="td-cell td-cell-day" v-if="index === 0" :rowspan="day.bikes.length">
                    <div class="rotate-text" v-text="day.day_name"></div>
                </td>

                <td class="td-cell td-cell-date" v-if="index === 0" :rowspan="day.bikes.length">
                    <div class="rotate-text" v-text="day.date"></div>
                </td>


                <td class="td-cell td-bike" v-text="bike.name"></td>
                <td v-bind:class="setClassAppointment(getAppointment('08:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('08:00', bike.id, day.date_record_time))? getAppointment('08:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('08:00', bike.id, day.date_record_time))? getAppointment('08:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('08:00', bike.id, day.date_record_time))? getAppointment('08:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('08:00', bike.id, day.date_record_time))? getAppointment('08:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('08:00', bike.id, day.date_record_time))? getAppointment('08:00', bike.id, day.date_record_time).time_from:'08:00',
                 'status':
                 (getAppointment('08:00', bike.id, day.date_record_time))? getAppointment('08:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('08:00', bike.id, day.date_record_time))? getAppointment('08:00', bike.id, day.date_record_time).time_to:'09:00',
                'date_record':
                (getAppointment('08:00', bike.id, day.date_record_time))? getAppointment('08:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('08:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('08:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('08:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('08:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('09:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('09:00', bike.id, day.date_record_time))? getAppointment('09:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('09:00', bike.id, day.date_record_time))? getAppointment('09:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('09:00', bike.id, day.date_record_time))? getAppointment('09:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('09:00', bike.id, day.date_record_time))? getAppointment('09:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('09:00', bike.id, day.date_record_time))? getAppointment('09:00', bike.id, day.date_record_time).time_from:'09:00',
                 'status':
                 (getAppointment('09:00', bike.id, day.date_record_time))? getAppointment('09:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('09:00', bike.id, day.date_record_time))? getAppointment('09:00', bike.id, day.date_record_time).time_to:'10:00',
                'date_record':
                (getAppointment('09:00', bike.id, day.date_record_time))? getAppointment('09:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('09:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('09:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('09:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('09:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('10:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('10:00', bike.id, day.date_record_time))? getAppointment('10:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('10:00', bike.id, day.date_record_time))? getAppointment('10:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('10:00', bike.id, day.date_record_time))? getAppointment('10:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('10:00', bike.id, day.date_record_time))? getAppointment('10:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('10:00', bike.id, day.date_record_time))? getAppointment('10:00', bike.id, day.date_record_time).time_from:'10:00',
                 'status':
                 (getAppointment('10:00', bike.id, day.date_record_time))? getAppointment('10:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('10:00', bike.id, day.date_record_time))? getAppointment('10:00', bike.id, day.date_record_time).time_to:'11:00',
                'date_record':
                (getAppointment('10:00', bike.id, day.date_record_time))? getAppointment('10:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('10:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('10:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('10:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('10:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('11:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('11:00', bike.id, day.date_record_time))? getAppointment('11:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('11:00', bike.id, day.date_record_time))? getAppointment('11:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('11:00', bike.id, day.date_record_time))? getAppointment('11:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('11:00', bike.id, day.date_record_time))? getAppointment('11:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('11:00', bike.id, day.date_record_time))? getAppointment('11:00', bike.id, day.date_record_time).time_from:'11:00',
                 'status':
                 (getAppointment('11:00', bike.id, day.date_record_time))? getAppointment('11:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('11:00', bike.id, day.date_record_time))? getAppointment('11:00', bike.id, day.date_record_time).time_to:'12:00',
                'date_record':
                (getAppointment('11:00', bike.id, day.date_record_time))? getAppointment('11:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('11:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('11:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('11:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('11:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('12:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('12:00', bike.id, day.date_record_time))? getAppointment('12:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('12:00', bike.id, day.date_record_time))? getAppointment('12:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('12:00', bike.id, day.date_record_time))? getAppointment('12:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('12:00', bike.id, day.date_record_time))? getAppointment('12:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('12:00', bike.id, day.date_record_time))? getAppointment('12:00', bike.id, day.date_record_time).time_from:'12:00',
                 'status':
                 (getAppointment('12:00', bike.id, day.date_record_time))? getAppointment('12:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('12:00', bike.id, day.date_record_time))? getAppointment('12:00', bike.id, day.date_record_time).time_to:'13:00',
                'date_record':
                (getAppointment('12:00', bike.id, day.date_record_time))? getAppointment('12:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('12:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('12:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('12:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('12:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('13:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('13:00', bike.id, day.date_record_time))? getAppointment('13:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('13:00', bike.id, day.date_record_time))? getAppointment('13:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('13:00', bike.id, day.date_record_time))? getAppointment('13:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('13:00', bike.id, day.date_record_time))? getAppointment('13:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('13:00', bike.id, day.date_record_time))? getAppointment('13:00', bike.id, day.date_record_time).time_from:'13:00',
                 'status':
                 (getAppointment('13:00', bike.id, day.date_record_time))? getAppointment('13:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('13:00', bike.id, day.date_record_time))? getAppointment('13:00', bike.id, day.date_record_time).time_to:'14:00',
                'date_record':
                (getAppointment('13:00', bike.id, day.date_record_time))? getAppointment('13:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('13:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('13:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('13:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('13:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('14:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('14:00', bike.id, day.date_record_time))? getAppointment('14:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('14:00', bike.id, day.date_record_time))? getAppointment('14:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('14:00', bike.id, day.date_record_time))? getAppointment('14:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('14:00', bike.id, day.date_record_time))? getAppointment('14:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('14:00', bike.id, day.date_record_time))? getAppointment('14:00', bike.id, day.date_record_time).time_from:'14:00',
                 'status':
                 (getAppointment('14:00', bike.id, day.date_record_time))? getAppointment('14:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('14:00', bike.id, day.date_record_time))? getAppointment('14:00', bike.id, day.date_record_time).time_to:'15:00',
                'date_record':
                (getAppointment('14:00', bike.id, day.date_record_time))? getAppointment('14:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('14:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('14:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('14:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('14:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('15:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('15:00', bike.id, day.date_record_time))? getAppointment('15:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('15:00', bike.id, day.date_record_time))? getAppointment('15:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('15:00', bike.id, day.date_record_time))? getAppointment('15:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('15:00', bike.id, day.date_record_time))? getAppointment('15:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('15:00', bike.id, day.date_record_time))? getAppointment('15:00', bike.id, day.date_record_time).time_from:'15:00',
                 'status':
                 (getAppointment('15:00', bike.id, day.date_record_time))? getAppointment('15:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('15:00', bike.id, day.date_record_time))? getAppointment('15:00', bike.id, day.date_record_time).time_to:'16:00',
                'date_record':
                (getAppointment('15:00', bike.id, day.date_record_time))? getAppointment('15:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('15:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('15:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('15:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('15:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('16:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('16:00', bike.id, day.date_record_time))? getAppointment('16:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('16:00', bike.id, day.date_record_time))? getAppointment('16:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('16:00', bike.id, day.date_record_time))? getAppointment('16:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('16:00', bike.id, day.date_record_time))? getAppointment('16:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('16:00', bike.id, day.date_record_time))? getAppointment('16:00', bike.id, day.date_record_time).time_from:'16:00',
                 'status':
                 (getAppointment('16:00', bike.id, day.date_record_time))? getAppointment('16:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('16:00', bike.id, day.date_record_time))? getAppointment('16:00', bike.id, day.date_record_time).time_to:'17:00',
                'date_record':
                (getAppointment('16:00', bike.id, day.date_record_time))? getAppointment('16:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('16:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('16:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('16:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('16:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('17:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('17:00', bike.id, day.date_record_time))? getAppointment('17:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('17:00', bike.id, day.date_record_time))? getAppointment('17:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('17:00', bike.id, day.date_record_time))? getAppointment('17:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('17:00', bike.id, day.date_record_time))? getAppointment('17:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('17:00', bike.id, day.date_record_time))? getAppointment('17:00', bike.id, day.date_record_time).time_from:'17:00',
                 'status':
                 (getAppointment('17:00', bike.id, day.date_record_time))? getAppointment('17:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('17:00', bike.id, day.date_record_time))? getAppointment('17:00', bike.id, day.date_record_time).time_to:'18:00',
                'date_record':
                (getAppointment('17:00', bike.id, day.date_record_time))? getAppointment('17:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('17:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('17:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('17:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('17:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('18:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('18:00', bike.id, day.date_record_time))? getAppointment('18:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('18:00', bike.id, day.date_record_time))? getAppointment('18:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('18:00', bike.id, day.date_record_time))? getAppointment('18:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('18:00', bike.id, day.date_record_time))? getAppointment('18:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('18:00', bike.id, day.date_record_time))? getAppointment('18:00', bike.id, day.date_record_time).time_from:'18:00',
                 'status':
                 (getAppointment('18:00', bike.id, day.date_record_time))? getAppointment('18:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('18:00', bike.id, day.date_record_time))? getAppointment('18:00', bike.id, day.date_record_time).time_to:'19:00',
                'date_record':
                (getAppointment('18:00', bike.id, day.date_record_time))? getAppointment('18:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('18:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('18:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('18:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('18:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('19:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('19:00', bike.id, day.date_record_time))? getAppointment('19:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('19:00', bike.id, day.date_record_time))? getAppointment('19:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('19:00', bike.id, day.date_record_time))? getAppointment('19:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('19:00', bike.id, day.date_record_time))? getAppointment('19:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('19:00', bike.id, day.date_record_time))? getAppointment('19:00', bike.id, day.date_record_time).time_from:'19:00',
                 'status':
                 (getAppointment('19:00', bike.id, day.date_record_time))? getAppointment('19:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('19:00', bike.id, day.date_record_time))? getAppointment('19:00', bike.id, day.date_record_time).time_to:'20:00',
                'date_record':
                (getAppointment('19:00', bike.id, day.date_record_time))? getAppointment('19:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('19:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('19:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('19:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('19:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('20:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('20:00', bike.id, day.date_record_time))? getAppointment('20:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('20:00', bike.id, day.date_record_time))? getAppointment('20:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('20:00', bike.id, day.date_record_time))? getAppointment('20:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('20:00', bike.id, day.date_record_time))? getAppointment('20:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('20:00', bike.id, day.date_record_time))? getAppointment('20:00', bike.id, day.date_record_time).time_from:'20:00',
                 'status':
                 (getAppointment('20:00', bike.id, day.date_record_time))? getAppointment('20:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('20:00', bike.id, day.date_record_time))? getAppointment('20:00', bike.id, day.date_record_time).time_to:'21:00',
                'date_record':
                (getAppointment('20:00', bike.id, day.date_record_time))? getAppointment('20:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('20:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('20:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('20:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('20:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>
                <td v-bind:class="setClassAppointment(getAppointment('21:00', bike.id, day.date_record_time).status)"
                    class="td-time-lesson" @click.prevent="$refs.modalOnlineAppointment.show({
                'id':
                (getAppointment('21:00', bike.id, day.date_record_time))? getAppointment('21:00', bike.id, day.date_record_time).id:'',
                'bike_id':
                (getAppointment('21:00', bike.id, day.date_record_time))? getAppointment('21:00', bike.id, day.date_record_time).bike_id:bike.id,
                   'text':
                   (getAppointment('21:00', bike.id, day.date_record_time))? getAppointment('21:00', bike.id, day.date_record_time).text:'',
                'phone':
                (getAppointment('21:00', bike.id, day.date_record_time))? getAppointment('21:00', bike.id, day.date_record_time).phone:'',
                'time_from':
                (getAppointment('21:00', bike.id, day.date_record_time))? getAppointment('21:00', bike.id, day.date_record_time).time_from:'21:00',
                 'status':
                 (getAppointment('21:00', bike.id, day.date_record_time))? getAppointment('21:00', bike.id, day.date_record_time).status:0,
                'time_to':
                (getAppointment('21:00', bike.id, day.date_record_time))? getAppointment('21:00', bike.id, day.date_record_time).time_to:'22:00',
                'date_record':
                (getAppointment('21:00', bike.id, day.date_record_time))? getAppointment('21:00', bike.id, day.date_record_time).date_record:day.date_record
                })">
                    <div>
                        <i v-if="getAppointment('21:00', bike.id, day.date_record_time)"
                           style="color: green; text-align: center"
                           class="fas fa-check"></i>
                    </div>
                    <div v-if="getAppointment('21:00', bike.id, day.date_record_time)"
                         class="appointment-data-client">
                        <div v-html="getAppointment('21:00', bike.id, day.date_record_time).text"></div>
                        <div v-text="getAppointment('21:00', bike.id, day.date_record_time).phone"></div>
                    </div>
                </td>

            </tr>

            </tbody>

        </table>


    </div>


</template>

<script>
import Vuex from 'vuex';
import axios from "axios";
import {createNamespacedHelpers} from 'vuex';
import modalOnlineAppointment from '../ModalOnlineAppointment/ModalOnlineAppointment';


const {mapGetters} = createNamespacedHelpers('onlineAppointment');

export default {
    name: "OnlineAppointmentTable",
    props: ['bikes'],
    components: {
        Vuex,
        axios,
        modalOnlineAppointment
    },
    watch: {
        appointments: function (newVal, oldVal) {


        },
        // при изменениях маршрута запрашиваем данные снова
        $route: function (newVal, oldVal) {
            let year = this.$route.params.year;
            let month = this.$route.params.month;


            console.log("Роут поменялся");

            this.getAppointments(year, month);


            console.log("Update Route Component");
            console.log("curDate");
            this.$store.commit('onlineAppointment/SET_SCROLLABLE', true);



        }
    },
    created: function () {

    },
    updated() {

        const curDate = this.currentFullDate;
        if (this.currentFullDate !== undefined && this.currentFullDate !== null && this.currentMonth !==undefined) {
            if (this.currentMonth === this.month && this.scrollable) {
                const elementTbody = document.getElementById("id-day-" + curDate);
                console.log("elementTbody");
                console.log(elementTbody);
                if (elementTbody !== null && elementTbody !== undefined) {
                    elementTbody.scrollIntoView(true);
                }
            }

        } else {
            document.scrollIntoView(true);
        }


    },
    mounted() {
        const path = `/${this.year}/${this.month}`
        if (this.$route.path !== path) {
            this.$router.push(path)
        } else {
            this.getAppointments(this.year, this.month);
        }

    },
    data() {
        return {
            findAppointment: null,
            curYear: this.year,
            curMonth: this.month,
            // months: null
        }
    },


    computed: {
        currentYear() {
            return new Date().getFullYear();
        },
        currentMonth() {
            return ("0" + (new Date().getMonth() + 1)).slice(-2);
        },
        year() {
            return this.$route.params.year || new Date().getFullYear();
        },
        month() {
            return this.$route.params.month || ("0" + (new Date().getMonth() + 1)).slice(-2);
        },
        currentFullDate() {
            return this.currentYear + "-" + this.currentMonth + "-" + this.currentDay;
        },
        //Получить текущий день
        currentDay() {
            return ("0" + new Date().getDate()).slice(-2);
        },
        ...mapGetters(['appointments', 'appointment', 'days', 'years', 'months', 'loader', 'message', 'scrollable']),
    },
    methods: {
        // Получить кол-во дней в конкретном месяце
        getDaysInMonth(month, year) {
            return new Date(year, month, 0).getDate();
        },
        setClassTr(className) {
            return "class-day-tbody class-day-" + className;

        },
        setIdTr(className) {
            return "id-day-" + className;

        },
        getAppointment(timeFrom, bikeId, dateRecord) {

            let element = this.appointments.find(appointment => {
                if
                (appointment.time_from === timeFrom
                    && appointment.bike_id === bikeId
                    && appointment.date_record === dateRecord) {
                    return appointment;
                }
            })
            if (element !== undefined) {
                return element;
            }
            return false;


        },
        setClassAppointment(status) {
            return {
                'appointment-yellow': status === 0,
                'appointment-green': status === 1,
                'appointment-red': status === 2,
            }
        },
        linkYear(year) {
            return '/' + year;
        },
        linkYearMonth(year, month) {
            return '/' + year + '/' + month;
        },

        ///Удаление онлайн-записи
        async deleteAppointment(id) {
            let isDelete = confirm("Вы действительно хотите удалить онлайн запись?");
            if (isDelete) {
                let curYear = this.year;
                let cyrMonth = this.month;

                await this.$store.dispatch('onlineAppointment/DELETE_APPOINTMENT', {
                    'year': curYear,
                    'id': id,
                    'month': cyrMonth
                });
            }
        },
        //Редактирование мотоцикла
        async editAppointment(id) {
            let curYear = this.year;
            let cyrMonth = this.month;

            await this.$store.dispatch('onlineAppointment/GET_APPOINTMENT', {
                'year': curYear,
                'id': id,
                'month': cyrMonth
            });
            this.$root.$refs.modalOnlineAppointment.show()
        },
        ///Получить все онлайн-записи
        async getAppointments(year, month = '') {
            await this.$store.dispatch('onlineAppointment/GET_ONLINE_APPOINTMENTS', {'year': year, 'month': month});

        },
        submit() {

        }
    }
}
</script>

<style lang="scss">
.wrapper-table-appointments {
    position: relative;


    table.responsive-table {
        display: table;
        /* required for table-layout to be used (not normally necessary; included for completeness) */
        table-layout: fixed;
        /* this keeps your columns with fixed with exactly the right width */
        width: 100%;
        /* table must have width set for fixed layout to work as expected */
        height: 100%;
    }


    table thead th {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    table thead th[scope=row] {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        z-index: 1;
    }

    table thead th:not([scope=row]) {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    table tbody {
        tr {

            .td-cell.td-bike {
                font-size: 12px;
            }

            .td-cell.td-cell-date, .td-cell.td-cell-day {
                vertical-align: middle;
            }

            .td-time-lesson {
                .fa.fa-check {
                    font-size: 12px;
                }
            }

            .td-time-lesson.appointment-green {
                background: #2a9055;

                .appointment-data-client {
                    * {
                        color: #fff;
                        font-weight: bold;
                        font-size: 12px;
                    }
                }
            }

            .td-time-lesson.appointment-red {
                background: #DB6360;

                .appointment-data-client {
                    * {
                        color: #fff;
                        font-weight: bold;
                        font-size: 12px;
                    }
                }
            }

            .td-time-lesson.appointment-yellow {
                background: #F5E76C;

                .appointment-data-client {
                    * {
                        color: black;
                        font-weight: bold;
                        font-size: 12px;
                    }
                }
            }

            //// Time Lesson
            .td-time-lesson {


                &:hover {
                    cursor: pointer;
                    outline: 1px solid green;
                }
            }

            //// Appointment
            .td-appointment {

            }

            ///// Bike
            .td-bike {

            }

        }
    }

    table, th, td {

        border-collapse: collapse;
    }

    th, td {
        padding: 3px;
        text-align: center;
    }

    table tr td {
        position: relative;
    }

    table thead {
        tr {
            .th-thead {
                font-size: 12px;
            }

            .th-time-work {
                font-size: 10px;
            }
        }
    }

    .rotate-text {
        text-align: center;
        white-space: nowrap;
        transform-origin: 50% 50%;
        transform: rotate(-90deg);
        font-size: 18px;
        font-weight: bold;

        &:before {
            content: '';
            padding-top: 210%; /* takes width as reference, + 10% for faking some extra padding */
            display: inline-block;
            vertical-align: middle;
        }

    }

}
</style>
