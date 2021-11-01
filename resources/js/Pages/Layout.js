import React, { useEffect, useState } from 'react'
import { Link } from '@inertiajs/inertia-react'
import { Inertia } from '@inertiajs/inertia'
import { Head } from '@inertiajs/inertia-react'
import { usePage } from '@inertiajs/inertia-react'
import '/css/sb-admin-2.min.css'
import '/js/sb-admin-2.min.js'


export default function Layout({ children }) {
const { users, user } = usePage().props
const [email, setEmail] = useState('')
const [data, setData] = useState([])
const handleClick = (id) =>{
  Inertia.post('/', {id})
}
  return (
    <main id="page-top">
      <Head title="Chattin Aja" />
      <div id="wrapper">
          <ul className="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <Link className="sidebar-brand d-flex align-items-center justify-content-center" href="/">
              <div className="sidebar-brand-text mx-3">Chattin aja</div>
            </Link>
            <hr className="sidebar-divider my-0" />
            <li className="nav-item">
              <p className="nav-link">
                <button type="button" className="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <i className="fas fa-search"></i>
                  Search User
                </button>
              </p>
              <div className="modal fade" id="exampleModal" tabIndex={-1} role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div className="modal-dialog" role="document">
                  <div className="modal-content">
                    <div className="modal-header">
                      <h5 className="modal-title" id="exampleModalLabel">Search User</h5>
                      <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div className="modal-body">
                      <input type="text" placeholder="Please Input User Email Only" className="form-control" onChange={(e)=>{
                      setData(Inertia.post('/user',{email:e.target.value}))
                    }} />
                      <p>User Found:</p>
                      <table className='table'>
                        <thead>
                          <tr>
                            <td>Username</td>
                            <td>Email</td>
                          </tr>
                        </thead>
                        <tbody>
                          {data.map((d)=>{
                            return(
                              <tr>
                                <td>{d.name}</td>
                                <td>{d.email}</td>
                              </tr>
                            )
                          })}
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li className="nav-item py-2" style={{height:'600px',overflow:'auto'}}>
            {users.map((pengguna)=>{
              if(pengguna.id == user.id){

              }else{

                return(
                  <p className="nav-link" onClick={()=>handleClick(pengguna.id)} key={pengguna.id}>
                    <img className="img-profile rounded-circle" src="/img/undraw_profile.svg" />
                    <span className="ml-2">{pengguna.name}</span>  
                  </p>
                )
              }
            })}
            </li>
            
          </ul>
          <div id="content-wrapper" className="d-flex flex-column">
            {children}
          </div>
        </div>
        <a className="scroll-to-top rounded" href="#page-top">
          <i className="fas fa-angle-up" />
        </a>
        <div className="modal fade" id="logoutModal" tabIndex={-1} role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div className="modal-dialog" role="document">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button className="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div className="modal-body">Select "Logout" below if you are ready to end your current session.</div>
              <div className="modal-footer">
                <button className="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a className="btn btn-primary" href="login.html">Logout</a>
              </div>
            </div>
          </div>
        </div>
    </main>
  )
}