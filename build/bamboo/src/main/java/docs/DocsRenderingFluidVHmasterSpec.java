package docs;

import com.atlassian.bamboo.specs.api.BambooSpec;
import com.atlassian.bamboo.specs.api.builders.BambooKey;
import com.atlassian.bamboo.specs.api.builders.Variable;
import com.atlassian.bamboo.specs.api.builders.plan.Job;
import com.atlassian.bamboo.specs.api.builders.plan.Plan;
import com.atlassian.bamboo.specs.api.builders.plan.Stage;
import com.atlassian.bamboo.specs.api.builders.plan.artifact.Artifact;
import com.atlassian.bamboo.specs.api.builders.plan.artifact.ArtifactSubscription;
import com.atlassian.bamboo.specs.api.builders.plan.branches.BranchCleanup;
import com.atlassian.bamboo.specs.api.builders.plan.branches.PlanBranchManagement;
import com.atlassian.bamboo.specs.api.builders.plan.configuration.AllOtherPluginsConfiguration;
import com.atlassian.bamboo.specs.api.builders.plan.configuration.ConcurrentBuilds;
import com.atlassian.bamboo.specs.api.builders.requirement.Requirement;
import com.atlassian.bamboo.specs.builders.task.ArtifactItem;
import com.atlassian.bamboo.specs.builders.task.CommandTask;
import com.atlassian.bamboo.specs.builders.task.ScriptTask;
import com.atlassian.bamboo.specs.builders.trigger.ScheduledTrigger;
import com.atlassian.bamboo.specs.util.BambooServer;
import com.atlassian.bamboo.specs.util.MapBuilder;

@BambooSpec
public class DocsRenderingFluidVHmasterSpec extends AbstractFluidVHSpec {
    private static String version = "master";
    private static String planName = "Docs - Rendering Fluid VH master";
    private static String planKey = "DRFVM";

    public static void main(String... argv) {
        // By default credentials are read from the '.credentials' file.
        BambooServer bambooServer = new BambooServer(bambooServerName);
        final DocsRenderingFluidVHmasterSpec planSpec = new DocsRenderingFluidVHmasterSpec();
        bambooServer.publish(planSpec.plan());
        bambooServer.publish(planSpec.getDefaultPlanPermissions(projectKey, planKey));
    }

    public Plan plan() {
        return configurePlan(new Plan(project(), planName, planKey), version);
    }
}
