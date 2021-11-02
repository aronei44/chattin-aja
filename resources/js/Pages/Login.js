import React, {useState} from 'react'
import Layout from './Layout'
import { usePage, Link } from '@inertiajs/inertia-react'
import { Inertia } from '@inertiajs/inertia'


export default function Login(){
	const { csrf } = usePage().props
	const [email, setEmail] = useState('')
	const [password, setPassword] = useState('')
	const handleClick = () =>{
		Inertia.post('/login', {email,password,_token:csrf})
	}
	return(
	<Layout>
		<div id="content">

      <nav className="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" style={{
      	position:'fixed',
      	top:'0px',
      	width:'100%',
      	zIndex:'999'
    	}}>
        
        <p className="navbar-brand">Chat App</p>
      </nav>
      <div className="container"style={{marginTop:'75px'}}>
        <div className="row justify-content-center">
	        <div className="col-md-8">
	          <div className="card">
	            <div className="card-header">Login</div>
	            <div className="card-body">
                <div className="form-group row">
                  <label htmlFor="email" className="col-md-4 col-form-label text-md-right">Email</label>
                  <div className="col-md-6">
                    <input type="email" className="form-control" autoFocus  onChange={(e)=>setEmail(e.target.value)}/>
                  </div>
                </div>
                <div className="form-group row">
                  <label htmlFor="password" className="col-md-4 col-form-label text-md-right">Password</label>
                  <div className="col-md-6">
                    <input type="password" className="form-control"  onChange={(e)=>setPassword(e.target.value)}/>
                  </div>
                </div>
                <div className="form-group row mb-0">
                	<div className="col-md-8 offset-md-4">
		                <button type="button" className="btn btn-primary" onClick={handleClick}>Login</button>
		                <span className="ml-5 mr-5">or</span>
		                <Link href="/register" className="btn btn-success">Register</Link>
                	</div>
                </div>
	            </div>
	          </div>
	        </div>
	      </div>
      </div>
    </div>
	</Layout>
	)
}