<template>
    <v-form>
        <v-container>
            <v-row>
                <v-col cols="12" sm="8" md="8">
                     <v-text-field 
            label="Solo"
            v-model="search"
            placeholder="Enter Vehicle Number"
            solo>
            </v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                </v-col>
            </v-row>
            <base-material-card
      color="success"
      dark
      icon="mdi-clipboard-plus"
      title="Driver Table"
      class="px-5 py-3"
    >
    <b v-if="items.length">{{ idFilter.length }} Recods Found</b>
      <v-simple-table>
        <thead>
          <tr style="background-color:gray">
            <th>NIC</th>
            <th>Report Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>Date of Birth</th>
            <th>Contact Number</th>
            <th>Vehicle Number</th>
            <th>Reports</th>
          </tr>
        </thead>

        <tbody >
          <tr v-for='item in idFilter' :key='items.pId'>
            <td>{{item.NIC}}</td>
            <td>rep_{{item.rId}}</td>
            <td>{{item.fName}}</td>
            <td>{{item.lName}}</td>
            <td>{{item.pAddress}}</td>
            <td>{{item.pDOB}}</td>
            <td>{{item.pContactNo}}</td>
            <td>{{item.vehicleNumber}}</td>
            <td><v-btn small
              color="warning" dark >
             View Report
            </v-btn></td>
          </tr>
        </tbody>
      </v-simple-table>
    </base-material-card>
  
      
   
        </v-container>
    </v-form>
</template>
<script>
import Axios from '../../../baseURL'
export default {
    data: () => ({
     items:[],
     search:'', 
    }),
    created()
    {
     
        Axios.get('driver-history').then(Response =>{
          this.items=Response.data;
        })
        .catch(function (error)
        {
          console.log('cannot get data'+ error);
        });
      
    },
    methods:
    {
      // sendMail()
      // {
      //   return axios.post('http://127.0.0.1:8000/api/api/sendMail').then(
      //         // Change to notify the user
      //         console.log('Method works')
      //         );
      // }
    },
    computed:
    {
      idFilter()
      {
        return this.items.filter(item => {
          return item.vehicleNumber.toLowerCase().includes(this.search.toLowerCase());
        })
      }
    },
}
</script>