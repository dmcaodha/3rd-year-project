package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import android.app.Application;

public class MyApplication extends Application {
	private AssignmentList assignments;
	private int userId;
	private int currentAssignId;
	private Survey currentSurvey;
	private int currentQuestId;
	
	public MyApplication() {
		this.assignments = null;
		this.userId = 0;
		this.currentAssignId = 0;
		this.currentSurvey = null;
		this.currentQuestId = 0;
	}
	
	public AssignmentList getAssignmentlist() { return this.assignments; }
	public void setAssignmentlist(AssignmentList al) { this.assignments = al; }
	public int getUserId() { return this.userId; }
	public void setUserId(int uId) { this.userId = uId; }
	public int getCurrentAssignId() { return this.currentAssignId; }
	public void setCurrentAssignId(int aId) { this.currentAssignId = aId; }
	public Survey getCurrentSurvey() { return this.currentSurvey; }
	public void setCurrentSurvey(Survey cs) { this.currentSurvey = cs; }
	public int getCurrentQuestionId() { return this.currentQuestId; }
	public void setCurrentQuestionId(int qId) { this.currentQuestId = qId; }
}
