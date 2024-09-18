import { Component } from '@angular/core';
import { ServerApiService } from '../server-api.service';
import { Inject } from '@angular/core';
import {FormGroup, FormControl, FormBuilder, Validators, NgForm} from '@angular/forms';
import {HttpEvent, HttpEventType} from "@angular/common/http";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {

  itSpecialists:any=[];
  centers:any=[];

  addTicket:FormGroup;
  numberRegEx = /\-?\d*\.?\d{1,2}/;
  progress:number=0;
  msg: string='';
  imgMsg: any;

  constructor(private service:ServerApiService,private fb:FormBuilder){
    this.addTicket=this.fb.group({
      ticketCenterId:['',Validators.required],
      ticketProblemDescription:['',Validators.required],
      ticketProblemType:['',Validators.required],
      ticketDeviceType:['',Validators.required],
      ticketEmployeeId:[0,Validators.required],
      ticketItSpecialistId:['',Validators.required],
      ticketOsVersion:["",Validators.required],
      ticketAffectedSoftware:['',Validators.required],
      ticketErrorCode:[""],
      ticketDeviceSN:[""],
      ticketScreenshot: [null]
    })
  }

  ngOnInit(){
    this.getAllCenters();
    this.getAllIts();

  }

  getAllIts(){
    this.service.getAllIts().subscribe((data:any)=>{
      this.itSpecialists=data.ItSpecialists
      console.log("IT",this.itSpecialists);
    })
  }

  
  getAllCenters(){
    this.service.getAllCenters().subscribe((data:any)=>{
      this.centers=data.centers
      console.log("centers",this.itSpecialists);
    })
  }

  onFileChange(event:any) {
    const file = event.target.files ? event.target.files[0] : '';      
      this.addTicket.get('ticketScreenshot')?.setValue(file);
    this.addTicket.patchValue({
      fileSource: file,
    });
    this.addTicket.get('ticketScreenshot')?.updateValueAndValidity();

  
  }

  addNewTicket(){


    this.service.addNewTicket(this.addTicket.value.ticketCenterId,this.addTicket.value.ticketProblemDescription,this.addTicket.value.ticketProblemType,this.addTicket.value.ticketDeviceType,this.addTicket.value.ticketEmployeeId,this.addTicket.value.ticketOsVersion,this.addTicket.value.ticketAffectedSoftware,this.addTicket.value.ticketErrorCode,this.addTicket.value.ticketDeviceSN,this.addTicket.value.ticketScreenshot).subscribe((event:HttpEvent<any>)=>{
      console.log(event)
      switch(event.type){
        case HttpEventType.UploadProgress:
          // var eventTotal=event.total ? event.total:0;
          if(event.total){
            this.progress=Math.round((100 / event.total) * event.loaded);
            this.msg='Uploaded!'+this.progress;
          }
          break;
          case HttpEventType.Response:
            event.body;
            // console.log(event.body)
            if(event.body.error){
              this.imgMsg=event.body.error;
              console.log("error",this.imgMsg);
              alert(this.imgMsg);
            }
            else if(event.body.success){
              this.imgMsg=event.body.msg;
              console.log("success",event.body)
            }
            setTimeout(()=>{
              this.progress=0;
              this.msg='';
               
            },3000)
      }
    })
  }
}
