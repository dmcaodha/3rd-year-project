package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class AssignmentXMLHandler extends DefaultHandler {
	
	private AssignmentList myAssignments;
	private Assignment currentAssignment;
	private Survey currentSurvey;
	private boolean inAssignments;
	private boolean inAssignment;
	private boolean inDateAssigned;
	private boolean inManagerNotes;
	private boolean inSurvey;
	private boolean inTitle;
	private boolean inTopic;

	// Method called when parser reads the beginning of an xml file
	public void startDocument() throws SAXException {
		this.myAssignments = new AssignmentList();
		this.currentAssignment = null;
		this.inAssignments = false;
		this.inAssignment = false;
		this.inDateAssigned = false;
		this.inManagerNotes = false;
		this.inSurvey = false;
		this.inTitle = false;
		this.inTopic = false;
	}

	public void endDocument() throws SAXException {
		// TODO Auto-generated method stub
		
	}
	// Method called when parser reads the beginning of an element tag in XML
	public void startElement(String uri, String localName, String qName,
			Attributes atts) throws SAXException {
		if (localName.equalsIgnoreCase("assignments")) {
			inAssignments = true;
			myAssignments.setUserId(Integer.parseInt(atts.getValue("userId")));
		}
		else if (localName.equalsIgnoreCase("assignment")) {
			inAssignment = true;
			currentAssignment = new Assignment();
			currentAssignment.id = Integer.parseInt(atts.getValue("id"));
		}
		else if (localName.equalsIgnoreCase("dateAssigned")) inDateAssigned = true;
		else if (localName.equalsIgnoreCase("managerNotes")) inManagerNotes = true;
		else if (localName.equalsIgnoreCase("survey")) {
			inSurvey = true;
			currentSurvey = new Survey();
			currentSurvey.id = Integer.parseInt(atts.getValue("id"));
		}
		else if (localName.equalsIgnoreCase("title")) inTitle = true;
		else if (localName.equalsIgnoreCase("topic")) inTopic = true;
	}
	// Method called when parser reads the end of an element tag in XML
	public void endElement(String uri, String localName, String qName)
			throws SAXException {
		if (localName.equalsIgnoreCase("assignments")) inAssignments = false;
		else if (localName.equalsIgnoreCase("assignment")) {
			inAssignment = false;
			myAssignments.addAssignment(currentAssignment);
			currentAssignment = null;
		}
		else if (localName.equalsIgnoreCase("dateAssigned")) inDateAssigned = false;
		else if (localName.equalsIgnoreCase("managerNotes")) inManagerNotes = false;
		else if (localName.equalsIgnoreCase("survey")) {
			inSurvey = false;
			currentAssignment.survey = currentSurvey;
			currentSurvey = null;
		}
		else if (localName.equalsIgnoreCase("title")) inTitle = false;
		else if (localName.equalsIgnoreCase("topic")) inTopic = false;
	}
	// Method called when parser reads the contents of an element tag in XML
	public void characters(char[] ch, int start, int length)
			throws SAXException {
		String content = new String(ch, start, length);
		if (inDateAssigned) currentAssignment.dateAssigned = content;
		else if (inManagerNotes) currentAssignment.managerNotes = content;
		else if (inTitle) currentSurvey.title = content;
		else if (inTopic) currentSurvey.topic = content;
	}
	
	public AssignmentList getAssignmentList() {
		return this.myAssignments;
	}
}
