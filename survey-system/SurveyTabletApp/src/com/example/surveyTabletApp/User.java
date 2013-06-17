package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

public class User {
	public int id;
	public String username;
	public String password;
	
	public User() {
		this.id = 0;
		this.username = "null";
		this.password = "null";
	}
	
	public int getUserId() { return this.id; }
	public void setUserId(int uId) { this.id = uId; }
	public String getUsername() { return this.username; }
	public void setUsername(String un) { this.username = un; }
	public String getPassword() { return this.password; }
	public void setPassword(String pw) { this.password = pw; }
}


