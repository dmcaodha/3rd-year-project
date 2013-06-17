package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import java.util.ArrayList;
import java.util.List;

public class AssignmentList {
	
	private List<Assignment> assignments;
	// This variable is added because the method for logging in
	// which returns an assignment list must also return the user's id
	private int userId;
	
	public AssignmentList() {
		this.assignments = new ArrayList<Assignment>();
		this.userId = 0;
	}
	
	public void addAssignment(Assignment a) { this.assignments.add(a); }
	public List<Assignment> getAssignments() { return this.assignments; }
	public int getUserId() { return this.userId; }
	public void setUserId(int uId) { this.userId = uId; }
}
