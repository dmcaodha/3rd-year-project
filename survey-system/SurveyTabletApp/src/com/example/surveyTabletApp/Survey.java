package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import java.util.ArrayList;
import java.util.List;

public class Survey {
	public int id;
	public String title;
	public String topic;
	public List<Question> questionsList;
	
	public Survey() {
		questionsList = new ArrayList<Question>();
	}
}