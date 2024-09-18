import { Injectable } from '@angular/core';
import { catchError, map} from 'rxjs/operators';
import {HttpClient, HttpParams, HttpHeaders } from "@angular/common/http";
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ServerApiService {

  baseURL:string="http://localhost/serverApi/";

  constructor(private http:HttpClient) { }

  getAllIts(){
    return this.http.get(this.baseURL+ "getIts.php");
  }

  getAllCenters(){
    return this.http.get(this.baseURL+ "getCenters.php");
  }



  public addNewTicket(ticketCenterId:any,ticketProblemDescription:any,ticketProblemType:any,ticketDeviceType:any,ticketEmployeeId:any,ticketOsVersion:any,ticketAffectedSoftware:any,ticketErrorCode:any,ticketDeviceSN:any,ticketScreenshot:any)
  {
    const method:string="new-ticket";
    return this.http.post<any>(this.baseURL + "serverApi.php",
      {method,ticketCenterId,ticketProblemDescription,ticketProblemType,ticketDeviceType,ticketEmployeeId,ticketOsVersion,ticketAffectedSoftware,ticketErrorCode,ticketDeviceSN,ticketScreenshot})
      .pipe(map(data=>{
        return data;
      }));
  }
}
